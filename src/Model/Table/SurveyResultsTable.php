<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyResults Model
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable|\Cake\ORM\Association\BelongsTo $Surveys
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable|\Cake\ORM\Association\BelongsTo $SurveyQuestions
 * @property |\Cake\ORM\Association\BelongsTo $SurveyAnswers
 * @property \Qobo\Survey\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Qobo\Survey\Model\Entity\SurveyResult get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyResult newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyResult[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyResult|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyResult patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyResult[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyResult findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveyResultsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('survey_results');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Surveys', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.Surveys'
        ]);
        $this->belongsTo('SurveyQuestions', [
            'foreignKey' => 'survey_question_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.SurveyQuestions'
        ]);
        $this->belongsTo('SurveyAnswers', [
            'foreignKey' => 'survey_answer_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.SurveyAnswers'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.Users'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('result')
            ->maxLength('result', 4294967295)
            ->allowEmpty('result');

        $validator
            ->dateTime('trashed')
            ->allowEmpty('trashed');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['survey_id'], 'Surveys'));
        $rules->add($rules->existsIn(['survey_question_id'], 'SurveyQuestions'));
        $rules->add($rules->existsIn(['survey_answer_id'], 'SurveyAnswers'));

        return $rules;
    }

    /**
     * Get Survey Result as indexed array
     * Certain answer options might contain
     * multiple answers, thus we create indexed array of those
     * records for later saving in DB table.
     *
     * @param array $data containing SurveyResults request data item
     * @param array $options containing user and survey instances
     *
     * @return array $result containing flat indexed array of all results.
     */
    public function getResults(array $data = [], array $options = [])
    {
        $result = [];

        if (empty($data)) {
            return $result;
        }

        $item = [
            'user_id' => $options['user']['id'],
            'survey_id' => $options['survey']->id,
            'survey_question_id' => $data['survey_question_id'],
            'result' => !empty($data['result']) ? $data['result'] : '',
            'submit_id' => !empty($options['data']['submit_id']) ? $options['data']['submit_id'] : null,
            'submit_date' => !empty($options['data']['submit_date']) ? $options['data']['submit_date'] : null,
        ];

        if (!is_array($data['survey_answer_id'])) {
            $item['survey_answer_id'] = $data['survey_answer_id'];
            array_push($result, $item);

            return $result;
        }

        foreach ($data['survey_answer_id'] as $answer) {
            $item['survey_answer_id'] = $answer;
            array_push($result, $item);
        }

        return $result;
    }

    /**
     * Saving Survey Results
     *
     * @param array $data containing results info
     * @return array $result containing save status
     */
    public function saveData(array $data = [])
    {
        $result = [
            'status' => false,
            'entity' => null,
        ];
        $entity = $this->newEntity();
        foreach ($data as $field => $value) {
            $entity->set($field, $value);
        }

        $saved = $this->save($entity);

        if ($saved) {
            $result['status'] = true;
            $result['entity'] = $saved;
        } else {
            $result['entity'] = $entity;
        }

        return $result;
    }

    /**
     * Get Survey Results group by submit_id
     *
     * @param string $surveyId with primary key
     * @param array $options with extra configs
     *
     * @return \Cake\ORM\Query|null $result with submits
     */
    public function getSubmits($surveyId = null, array $options = [])
    {
        $result = null;

        $options['contains'] = empty($options['contains']) ? ['Users'] : $options['contains'];

        if (empty($surveyId)) {
            return $result;
        }

        $query = $this->find()
            ->where(['survey_id' => $surveyId])
            ->group('submit_id');

        $query->contain($options['contains']);

        if (!$query->count()) {
            return $result;
        }

        $result = $query->all();

        return $result;
    }
}

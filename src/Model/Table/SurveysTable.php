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

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Surveys Model
 *
 * @method \Qobo\Survey\Model\Entity\Survey get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\Survey newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\Survey[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\Survey|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\Survey patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\Survey[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\Survey findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveysTable extends Table
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

        $this->setTable('surveys');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Muffin/Slug.Slug');

        $this->addBehavior('Duplicatable.Duplicatable', [
            'finder' => 'all',
            'contain' => ['SurveyQuestions.SurveyAnswers'],
            'remove' => ['publish_date', 'created', 'modified', 'slug'],
            'append' => [
                'name' => ' - (duplicated: ' . date('Y-m-d H:i', time()) . ')',
            ]
        ]);

        $this->hasMany('SurveyQuestions', [
            'foreignKey' => 'survey_id',
            'className' => 'Qobo/Survey.SurveyQuestions',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        $validator
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('version');

        $validator
            ->scalar('description')
            ->maxLength('description', 4294967295)
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

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
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }

    /**
     * Get Survey Categories
     *
     * @return array $result list of categories.
     */
    public function getSurveyCategories()
    {
        $result = [];
        $config = Configure::read('Survey.Categories');

        if (!empty($config)) {
            $result = Hash::combine($config, '{n}.value', '{n}.name');
        }

        return $result;
    }

    /**
     * Get Survey full data including q&a with results.
     *
     * @param string|null $surveyId for the record
     * @param bool $contain to attach containable Q&A entities or not.
     *
     * @return array $result containing the survey's data.
     */
    public function getSurveyData($surveyId = null, $contain = false)
    {
        $result = [];

        if (empty($surveyId)) {
            return $result;
        }

        $query = $this->find('all');
        $query->limit(1);
        $query->where(['Surveys.id' => $surveyId]);
        $query->orWhere(['Surveys.slug' => $surveyId]);
        if ($contain) {
            $query->contain(['SurveyQuestions' => [
                'sort' => ['SurveyQuestions.order' => 'ASC'],
                'SurveyAnswers' => [
                    'sort' => ['SurveyAnswers.order' => 'ASC'],
                    'SurveyResults'
                ]
            ]]);
        }

        $query->execute();

        if (!$query->count()) {
            return $result;
        }

        $result = $query->firstOrFail();

        return $result;
    }

    /**
     * Pre-publish validate of Survey
     *
     * We make sure the user didn't forget to add at least
     * one answer option to survey question
     *
     * @param mixed $id of the survey or its slug
     * @param \Cake\Network\Request $request object from controller
     * @return array $response with status flag and possible errors
     */
    public function prepublishValidate($id, $request = null)
    {
        $response = [
            'status' => false,
            'errors' => []
        ];
        $entity = $this->getSurveyData($id, true);

        foreach ($entity->survey_questions as $question) {
            if (!empty($question->survey_answers)) {
                continue;
            }

            $response['errors'][] = "Question \"" . $question->question . "\" must have at least one answer option.";
        }

        if (empty($response['errors'])) {
            $response['status'] = true;
        }

        if (!empty($request)) {
            $data = $request->getData();
            $publish = strtotime($data['Surveys']['publish_date']);
            $expiry = strtotime($data['Surveys']['expiry_date']);
            if ($expiry > $publish) {
                $response['status'] = true;
            } else {
                $response['errors'][] = __('Expiry date should be bigger than publish date');
                $response['status'] = false;
            }
        }

        return $response;
    }

    /**
     * Align questions and answer options of survey in
     * sequence
     *
     * @param \Cake\Datasource\EntityInterface $entity of the survey
     * @return bool $sorted for sorting result
     */
    public function setSequentialOrder(EntityInterface $entity)
    {
        $sorted = false;
        $questions = TableRegistry::get('Qobo/Survey.SurveyQuestions');
        $answers = TableRegistry::get('Qobo/Survey.SurveyAnswers');

        $query = $questions->find()
            ->where(['survey_id' => $entity->id])
            ->order(['order' => 'ASC']);

        $entities = $query->all()->toArray();

        if (empty($entities)) {
            return $sorted;
        }

        $sorted = $questions->setOrder($entities);

        foreach ($entities as $entity) {
            $query = $answers->find()
                ->where(['survey_question_id' => $entity->id])
                ->order(['order' => 'ASC']);

            $items = $query->all()->toArray();

            if (!empty($items)) {
                $sorted = $answers->setOrder($items);
            }
        }

        return $sorted;
    }
}

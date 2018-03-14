<?php
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}

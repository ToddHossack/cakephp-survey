<?php
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyAnswers Model
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable|\Cake\ORM\Association\BelongsTo $Surveys
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable|\Cake\ORM\Association\BelongsTo $SurveyQuestions
 * @property \Qobo\Survey\Model\Table\SurveyChoicesTable|\Cake\ORM\Association\BelongsTo $SurveyChoices
 * @property \Qobo\Survey\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyAnswer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveyAnswersTable extends Table
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

        $this->setTable('survey_answers');
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
        $this->belongsTo('SurveyChoices', [
            'foreignKey' => 'survey_choice_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.SurveyChoices'
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
            ->scalar('answer')
            ->maxLength('answer', 4294967295)
            ->allowEmpty('answer');

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
        $rules->add($rules->existsIn(['survey_choice_id'], 'SurveyChoices'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}

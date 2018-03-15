<?php
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyQuestions Model
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable|\Cake\ORM\Association\BelongsTo $Surveys
 * @property |\Cake\ORM\Association\HasMany $SurveyAnswers
 * @property |\Cake\ORM\Association\HasMany $SurveyResults
 *
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveyQuestionsTable extends Table
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

        $this->setTable('survey_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Surveys', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.Surveys'
        ]);
        $this->hasMany('SurveyAnswers', [
            'foreignKey' => 'survey_question_id',
            'className' => 'Qobo/Survey.SurveyAnswers'
        ]);
        $this->hasMany('SurveyResults', [
            'foreignKey' => 'survey_question_id',
            'className' => 'Qobo/Survey.SurveyResults'
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
            ->scalar('question')
            ->maxLength('question', 4294967295)
            ->requirePresence('question', 'create')
            ->notEmpty('question');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
        $rules->add($rules->existsIn(['survey_id'], 'Surveys'));

        return $rules;
    }

    /**
     * Get defined list of Question types currently available
     *
     * @return array $list of question types.
     */
    public function getQuestionTypes()
    {
        return [
            'input' => 'Short Text',
            'textarea' => 'Paragraph',
            'checkbox' => 'Multiple Checkboxes',
            'radio' => 'Radio Buttons',
            'select' => 'Dropdown',
        ];
    }
}

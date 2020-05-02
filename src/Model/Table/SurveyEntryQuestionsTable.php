<?php
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyEntryQuestions Model
 *
 * @property \Qobo\Survey\Model\Table\SurveyEntriesTable|\Cake\ORM\Association\BelongsTo $SurveyEntries
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable|\Cake\ORM\Association\BelongsTo $SurveyQuestions
 *
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntryQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveyEntryQuestionsTable extends Table
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

        $this->setTable('survey_entry_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->belongsTo('SurveyEntries', [
            'foreignKey' => 'survey_entry_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.SurveyEntries',
        ]);
        $this->belongsTo('SurveyQuestions', [
            'foreignKey' => 'survey_question_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.SurveyQuestions',
        ]);

        $this->hasMany('SurveyResults', [
            'foreignKey' => 'survey_entry_question_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.SurveyResults',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmptyString('status');

        $validator
            ->integer('score');

        $validator
            ->dateTime('trashed')
            ->allowEmptyDateTime('trashed');

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
        $rules->add($rules->existsIn('survey_entry_id', 'SurveyEntries'));
        $rules->add($rules->existsIn('survey_question_id', 'SurveyQuestions'));

        return $rules;
    }
}

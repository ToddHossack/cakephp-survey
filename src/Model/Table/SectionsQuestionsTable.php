<?php
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SectionsQuestions Model
 *
 * @property \Qobo\Survey\Model\Table\SurveySectionsTable|\Cake\ORM\Association\BelongsTo $SurveySections
 * @property \Qobo\Survey\Model\Table\SurveyQuestionsTable|\Cake\ORM\Association\BelongsTo $SurveyQuestions
 *
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SectionsQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SectionsQuestionsTable extends Table
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

        $this->setTable('sections_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SurveySections', [
            'foreignKey' => 'survey_section_id',
            'className' => 'Qobo/Survey.SurveySections'
        ]);

        $this->belongsTo('SurveyQuestions', [
            'foreignKey' => 'survey_question_id',
            'className' => 'Qobo/Survey.SurveyQuestions'
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
            ->integer('order')
            ->allowEmpty('order');

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
        $rules->add($rules->existsIn(['survey_section_id'], 'SurveySections'));
        $rules->add($rules->existsIn(['survey_question_id'], 'SurveyQuestions'));

        return $rules;
    }
}

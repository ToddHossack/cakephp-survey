<?php
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyChoices Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $SurveyQuestions
 *
 * @method \Qobo\Survey\Model\Entity\SurveyChoice get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyChoice newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyChoice[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyChoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyChoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyChoice[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyChoice findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveyChoicesTable extends Table
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

        $this->setTable('survey_choices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SurveyQuestions', [
            'foreignKey' => 'survey_question_id',
            'joinType' => 'INNER',
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
            ->scalar('choice')
            ->maxLength('choice', 4294967295)
            ->requirePresence('choice', 'create')
            ->notEmpty('choice');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 4294967295)
            ->allowEmpty('comment');

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
        $rules->add($rules->existsIn(['survey_question_id'], 'SurveyQuestions'));

        return $rules;
    }
}

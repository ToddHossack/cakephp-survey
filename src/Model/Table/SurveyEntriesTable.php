<?php
namespace Qobo\Survey\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyEntries Model
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable|\Cake\ORM\Association\BelongsTo $Surveys
 * @property \Qobo\Survey\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Qobo\Survey\Model\Entity\SurveyEntry get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntry newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntry[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntry|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntry[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyEntry findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveyEntriesTable extends Table
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

        $this->setTable('survey_entries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->belongsTo('Surveys', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.Surveys'
        ]);

        $this->hasMany('SurveyResults', [
            'foreignKey' => 'submit_id',
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmpty('status');

        $validator
            ->integer('grade')
            ->allowEmpty('grade');

        $validator
            ->scalar('context')
            ->maxLength('context', 4294967295)
            ->allowEmpty('context');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 4294967295)
            ->allowEmpty('comment');

        $validator
            ->dateTime('submit_date')
            ->allowEmpty('submit_date');

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
     * BeforeSave method
     *
     * Any time we receive a new submit of survey we should make sure that
     * it has general status/grade.
     *
     * @param \Cake\Event\Event $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     *
     * @return void
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options) : void
    {
        if (is_null($entity->get('status'))) {
            $entity->set('status', 'received');
        }

        if (is_null($entity->get('gradde'))) {
            $entity->set('grade', 0);
        }
    }
}

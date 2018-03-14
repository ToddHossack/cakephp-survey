<?php
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
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
            ->scalar('version')
            ->maxLength('version', 255)
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
}

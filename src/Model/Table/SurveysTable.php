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

use App\Model\Table\AppTable;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
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
class SurveysTable extends AppTable
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

        $this->addBehavior('Duplicatable.Duplicatable', [
            'finder' => 'all',
            'contain' => ['SurveyQuestions.SurveyAnswers'],
            'remove' => ['publish_date', 'created', 'modified'],
            'append' => ['name' => ' - (duplicated: ' . date('Y-m-d H:i', time()) . ')']
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
     *
     * @return array $result containing the survey's data.
     */
    public function getSurveyData($surveyId = null)
    {
        $result = [];

        if (empty($surveyId)) {
            return $result;
        }

        $query = $this->find();
        $query->where(['id' => $surveyId]);
        $query->contain(['SurveyQuestions' => [
            'sort' => ['SurveyQuestions.order' => 'ASC'],
            'SurveyAnswers' => [
                'sort' => ['SurveyAnswers.order' => 'ASC'],
                'SurveyResults'
            ]
        ]]);

        $query->execute();

        if (!$query->count()) {
            return $result;
        }

        $result = $query->first();

        return $result;
    }
}

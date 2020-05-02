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
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyQuestions Model
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable|\Cake\ORM\Association\BelongsTo $Surveys
 * @property \Cake\ORM\Association\HasMany $SurveyAnswers
 * @property \Cake\ORM\Association\HasMany $SurveyResults
 *
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveyQuestion findOrCreate($search, callable $callback = null, $options = [])
 * @method \ADmad\Sequence\Model\Behavior\SequenceBehavior setOrder(array $records)
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
        $this->addBehavior('ADmad/Sequence.Sequence', [
            'order' => 'order',
            'scope' => ['survey_id'],
            'start' => 1,
        ]);

        $this->belongsTo('Surveys', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.Surveys',
        ]);

        $this->belongsTo('SurveySections', [
            'foreignKey' => 'survey_section_id',
            'className' => 'Qobo/Survey.SurveySections',
        ]);

        $this->hasMany('SurveyAnswers', [
            'foreignKey' => 'survey_question_id',
            'className' => 'Qobo/Survey.SurveyAnswers',
        ]);
        $this->hasMany('SurveyResults', [
            'foreignKey' => 'survey_question_id',
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
            ->scalar('question')
            ->maxLength('question', 4294967295)
            ->requirePresence('question', 'create')
            ->notEmptyString('question');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->boolean('active');

        $validator
            ->boolean('is_required');

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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['survey_id'], 'Surveys'));

        return $rules;
    }

    /**
     * Get defined list of Question types currently available
     *
     * @return mixed[] $list of question types.
     */
    public function getQuestionTypes(): array
    {
        return Configure::read('Survey.Options.questions');
    }
}

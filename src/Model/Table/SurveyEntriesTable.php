<?php
namespace Qobo\Survey\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Qobo\Survey\Model\Entity\SurveyEntry;
use Qobo\Survey\Model\Entity\SurveyEntryQuestion;
use Webmozart\Assert\Assert;

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
            'className' => 'Qobo/Survey.Surveys',
        ]);

        $this->hasMany('SurveyEntryQuestions', [
            'foreignKey' => 'survey_entry_id',
            'joinType' => 'INNER',
            'className' => 'Qobo/Survey.SurveyEntryQuestions',
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
     * @param \Cake\Event\Event $event received
     * @param \Cake\Datasource\EntityInterface $entity of the entry
     * @param \ArrayObject $options configs
     *
     * @return void
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options): void
    {
        if (is_null($entity->get('status'))) {
            $entity->set('status', 'received');
        }

        if (is_null($entity->get('gradde'))) {
            $entity->set('grade', 0);
        }
    }

    /**
     * Retrieve survey entry statuses
     *
     * @return mixed[] result of configs for `Survey.Options.statuses`
     */
    public function getStatuses(): array
    {
        return Configure::read('Survey.Options.statuses');
    }

    /**
     * Save Survey Entry with its corresponding entry_questions and survey_results bond to it.
     *
     * @param mixed[] $surveyResults containing request->getData('SurveyResults')
     * @param \Cake\Datasource\EntityInterface $resource instance to which the survey is linked.
     * @param string $surveyId with possible extra configs
     *
     * @return bool|\Qobo\Survey\Model\Entity\SurveyEntry $savedEntry of created submitted entry
     */
    public function saveSurveyEntryData(array $surveyResults, EntityInterface $resource, string $surveyId)
    {
        /** @var \Qobo\Survey\Model\Table\SurveyResultsTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');
        $surveyResultsTable = $table;

        /** @var \Qobo\Survey\Model\Table\SurveyEntryQuestionsTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntryQuestions');
        $surveyEntryQuestionsTable = $table;

        $entry = $this->newEntity();
        $entry->set('resource', $resource->getSource());
        $entry->set('resource_id', $resource->get('id'));
        $entry->set('survey_id', $surveyId);
        $entry->set('submit_date', Time::now());
        $entry->set('status', 'in_review');

        $savedEntry = $this->save($entry);
        Assert::isInstanceOf($savedEntry, SurveyEntry::class);

        foreach ($surveyResults as $item) {
            $questionEntry = $surveyEntryQuestionsTable->newEntity();
            $questionEntry->set('survey_entry_id', $savedEntry->get('id'));
            $questionEntry->set('survey_question_id', $item['survey_question_id']);

            $surveyEntryQuestionsTable->save($questionEntry);
            Assert::isInstanceOf($questionEntry, SurveyEntryQuestion::class);

            if (!is_array($item['survey_answer_id'])) {
                $result = $surveyResultsTable->saveResultsEntity($savedEntry, $item, $questionEntry);
            } else {
                foreach ($item['survey_answer_id'] as $answer) {
                    $tmp = $item;
                    $tmp['survey_answer_id'] = $answer;
                    $result = $surveyResultsTable->saveResultsEntity($savedEntry, $tmp, $questionEntry);
                }
            }
        }

        return $savedEntry;
    }

    /**
     * Collect Survey Entry payload in array, including entry questions and survey results
     *
     * Payload example:
     * [
     *    'Surveys' => ['id', 'slug'],
     *    'SurveyEntries' => ['id', 'resource', 'resource_id', 'status', 'score', 'submit_date'],
     *    'SurveyEntryQuestions' => [
     *        [
     *            'id', 'status', 'score', 'survey_question_id',
     *            'survey_results' => [
     *                  'id', 'survey_answer_id', 'result'
     *            ]
     *        ]
     *    ]
     * ]
     *
     * @param string $id of SurveyEntries instance
     *
     * @return mixed[] $result containing the payload with all required saved entries
     */
    public function getSurveyEntryPayload(string $id): array
    {
        $data = [];
        $surveysTable = TableRegistry::getTableLocator()->get('Qobo/Survey.Surveys');

        $entry = $this->get($id);
        $survey = $surveysTable->get($entry->get('survey_id'));

        /** @var \Cake\ORM\Query $query */
        $query = $this->find()
            ->enableHydration(true)
            ->where([
                'id' => $id,
            ])
            ->contain(['SurveyEntryQuestions' => ['SurveyResults']]);

        if (! $query->count()) {
            return $data;
        }

        foreach ($query as $entity) {
            $data['Surveys'] = [
                'id' => $survey->get('id'),
                'slug' => $survey->get('slug'),
            ];

            $data['SurveyEntries'] = [
                'id' => $entity->get('id'),
                'resource' => $entity->get('resource'),
                'resource_id' => $entity->get('resource_id'),
                'status' => $entity->get('status'),
                'score' => $entity->get('score'),
                'submit_date' => $entity->get('submit_date')->i18nFormat('yyyy-MM-dd HH:mm:ss'),
            ];

            $data['SurveyEntryQuestions'] = [];

            if (empty($entity->get('survey_entry_questions'))) {
                continue;
            }

            foreach ($entity->get('survey_entry_questions') as $entryQuestion) {
                $tmp['id'] = $entryQuestion->get('id');
                $tmp['status'] = $entryQuestion->get('status');
                $tmp['score'] = $entryQuestion->get('score');
                $tmp['survey_question_id'] = $entryQuestion->get('survey_question_id');
                $tmp['survey_results'] = [];

                if (! empty($entryQuestion->get('survey_results'))) {
                    foreach ($entryQuestion->get('survey_results') as $submit) {
                        $submitItem['id'] = $submit->get('id');
                        $submitItem['survey_answer_id'] = $submit->get('survey_answer_id');
                        $submitItem['result'] = $submit->get('result');

                        $tmp['survey_results'][] = $submitItem;
                    }
                }

                $data['SurveyEntryQuestions'][] = $tmp;
            }
        }

        return $data;
    }
}

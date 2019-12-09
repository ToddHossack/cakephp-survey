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

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use Qobo\Survey\Event\EventName;
use Webmozart\Assert\Assert;

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
 * @method \Duplicatable\Model\Behavior\DuplicatableBehavior duplicate($id)
 * @method \ADmad\Sequence\Model\Behavior\SequenceBehavior setOrder(array $records)
 * @method \ADmad\Sequence\Model\Behavior\SequenceBehavior moveUp($entity)
 * @method \ADmad\Sequence\Model\Behavior\SequenceBehavior moveDown($entity)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveysTable extends Table
{

    /**
     * Initialize method
     *
     * @param mixed[] $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('surveys');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Muffin/Slug.Slug');

        $this->addBehavior('Duplicatable.Duplicatable', [
            'finder' => 'all',
            'contain' => ['SurveySections.SurveyQuestions.SurveyAnswers'],
            'remove' => ['publish_date', 'created', 'modified', 'slug', 'expiry_date'],
            'append' => [
                'name' => ' - (duplicated: ' . date('Y-m-d H:i', time()) . ')',
            ],
        ]);

        $this->hasMany('SurveyQuestions', [
            'foreignKey' => 'survey_id',
            'className' => 'Qobo/Survey.SurveyQuestions',
        ]);

        $this->hasMany('SurveySections', [
            'foreignKey' => 'survey_id',
            'className' => 'Qobo/Survey.SurveySections',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        $validator
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }

    /**
     * afterSave callback.
     *
     * Dispatches current model after save event(s).
     *
     * @param \Cake\Event\Event $event The afterSave event that was fired.
     * @param \Cake\Datasource\EntityInterface $entity The entity that was saved.
     * @param \ArrayObject $options The entity that was saved.
     * @return void
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options): void
    {
        if ($entity->isNew()) {
            /** @var \Qobo\Survey\Model\Table\SurveySectionsTable $table */
            $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveySections');

            $query = $table->find()
                ->where([
                    'survey_id' => $entity->get('id'),
                    'name' => $table::DEFAULT_SECTION_NAME,
                ]);

            if (! $query->count()) {
                $table->createDefaultSection($entity->get('id'));
            }
        }

        // Publish survey
        if (!empty($options['publishSurvey'])) {
            $publishEvent = new Event((string)EventName::PUBLISH_SURVEY(), $this, [
                'data' => [
                    'action' => 'add_survey',
                    'survey' => $this->getSurveyData($entity->get('id'), true),
                ],
            ]);
            $this->getEventManager()->dispatch($publishEvent);
        }
    }

    /**
     * Get Survey Categories
     *
     * @return mixed[] $result list of categories.
     */
    public function getSurveyCategories(): array
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
     * @param bool $contain to attach containable Q&A entities or not.
     *
     * @return \Cake\Datasource\EntityInterface|null $result containing the survey's data.
     */
    public function getSurveyData(string $surveyId = null, bool $contain = false): ?EntityInterface
    {
        $result = null;

        if (empty($surveyId)) {
            return $result;
        }

        $query = $this->find('all');
        // $query->limit(1);
        // making sure that entities returned instead of arrays.
        $query->enableHydration(true);
        $query->where([
            'OR' => [
                'Surveys.id' => $surveyId,
                'Surveys.slug' => $surveyId,
            ],
        ]);
        if ($contain) {
            $query->contain([
                'SurveySections' => [
                    'sort' => ['SurveySections.order' => 'ASC'],
                    'SurveyQuestions' => [
                        'sort' => ['SurveyQuestions.order' => 'ASC'],
                        'SurveyAnswers' => [
                            'sort' => ['SurveyAnswers.order' => 'ASC'],
                            'SurveyResults',
                        ],
                    ],
                ],
            ]);
        }

        $query->execute();

        if (! $query->count()) {
            return $result;
        }

        /**
         * @var \Cake\Datasource\EntityInterface|null
         */
        $result = $query->first();

        return $result;
    }

    /**
     * Pre-publish validate of Survey
     *
     * We make sure the user didn't forget to add at least
     * one answer option to survey question
     *
     * @param string $id of the survey or its slug
     * @param \Cake\Http\ServerRequest $request object from controller
     * @return mixed[] $response with status flag and possible errors
     */
    public function prepublishValidate(string $id, ServerRequest $request = null): array
    {
        $response = [
            'status' => false,
            'errors' => [],
        ];
        $entity = $this->getSurveyData($id, true);
        Assert::isInstanceOf($entity, EntityInterface::class);

        foreach ($entity->get('survey_sections') as $section) {
            foreach ($section->get('survey_questions') as $question) {
                if (!empty($question->get('survey_answers'))) {
                    continue;
                }

                $response['errors'][] = "Question \"" . $question->get('question') . "\" must have at least one answer option.";
            }
        }
        if (empty($response['errors'])) {
            $response['status'] = true;
        }

        if (!empty($request)) {
            $validated = $this->validatePublishDate((array)$request->getData());
            $response['status'] = $validated;

            if (!$validated) {
                $response['errors'][] = __('Expiry date should be bigger than publish date');
            }
        }

        return $response;
    }

    /**
     * Validate That Survey has correct expiration date
     *
     * @param mixed[] $data containing Surveys request data
     * @return bool $validated for expiration date.
     */
    public function validatePublishDate(array $data = []): bool
    {
        $validated = false;

        $publish = strtotime($data['Surveys']['publish_date']);
        $expiry = strtotime($data['Surveys']['expiry_date']);

        $validated = ($expiry > $publish) ? true : false;

        return $validated;
    }

    /**
     * Align questions and answer options of survey in
     * sequence
     *
     * @param \Cake\Datasource\EntityInterface $entity of the survey
     * @return \ADmad\Sequence\Model\Behavior\SequenceBehavior|bool $sorted for sorting result
     */
    public function setSequentialOrder(EntityInterface $entity)
    {
        $sorted = false;
        /**
         * @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $questions
         */
        $questions = TableRegistry::get('Qobo/Survey.SurveyQuestions');

        /**
         * @var \Qobo\Survey\Model\Table\SurveyAnswersTable $answers
         */
        $answers = TableRegistry::get('Qobo/Survey.SurveyAnswers');

        $query = $questions->find()
            ->where(['survey_id' => $entity->get('id')])
            ->order(['order' => 'ASC']);

        $entities = $query->all()->toArray();

        if (empty($entities)) {
            return $sorted;
        }

        $sorted = $questions->setOrder($entities);

        foreach ($entities as $entity) {
            $query = $answers->find()
                ->where(['survey_question_id' => $entity->id])
                ->order(['order' => 'ASC']);

            $items = $query->all()->toArray();

            if (!empty($items)) {
                $sorted = $answers->setOrder($items);
            }
        }

        return $sorted;
    }
}

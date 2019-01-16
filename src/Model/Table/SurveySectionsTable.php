<?php
namespace Qobo\Survey\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * SurveySections Model
 *
 * @property \Qobo\Survey\Model\Table\SurveysTable|\Cake\ORM\Association\BelongsTo $Surveys
 *
 * @method \Qobo\Survey\Model\Entity\SurveySection get($primaryKey, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveySection newEntity($data = null, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveySection[] newEntities(array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveySection|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveySection|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveySection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveySection[] patchEntities($entities, array $data, array $options = [])
 * @method \Qobo\Survey\Model\Entity\SurveySection findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SurveySectionsTable extends Table
{
    const DEFAULT_SECTION_NAME = 'Default';

    const DEFAULT_SECTION_ORDER = 1;

    const DEFAULT_ACTIVE_FLAG = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('survey_sections');
        $this->setDisplayField('name');
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
            'className' => 'Qobo/Survey.Surveys'
        ]);

        $this->hasMany('SurveyQuestions', [
            'foreignKey' => 'survey_section_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

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
     * Create Default Section for the survey
     *
     * @param string $surveyId for the relation.
     * @return \Cake\Datasource\EntityInterface|false $result
     */
    public function createDefaultSection(string $surveyId)
    {
        $entity = $this->newEntity();

        $entity->set('name', self::DEFAULT_SECTION_NAME);
        $entity->set('order', self::DEFAULT_SECTION_ORDER);
        $entity->set('active', self::DEFAULT_ACTIVE_FLAG);

        $entity->set('survey_id', $surveyId);

        return $this->save($entity);
    }

    /**
     * Get Survey Sections list
     *
     * @param string $id of the survey (not slug)
     * @return mixed[] $result
     */
    public function getSurveySectionsList(string $id): array
    {
        $result = [];

        $query = $this->find('list')
            ->where([
                'survey_id' => $id,
            ]);

        $result = $query->toArray();

        return $result;
    }
}

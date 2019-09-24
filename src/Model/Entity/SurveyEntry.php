<?php
namespace Qobo\Survey\Model\Entity;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * SurveyEntry Entity
 *
 * @property string $id
 * @property string $survey_id
 * @property string $user_id
 * @property string|null $status
 * @property int|null $grade
 * @property string|null $context
 * @property string|null $comment
 * @property \Cake\I18n\Time|null $submit_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time|null $trashed
 *
 * @property \Qobo\Survey\Model\Entity\Survey $survey
 * @property \Qobo\Survey\Model\Entity\User $user
 */
class SurveyEntry extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
    ];

    /**
     * Return array of the resource, that contains it's url and displayfield
     *
     * @return mixed[] $result
     */
    protected function _getResourceUser() : array
    {
        $result = [];
        $table = TableRegistry::getTableLocator()->get($this->get('resource'));

        try {
            $user = $table->get($this->get('resource_id'));

            $result['displayField'] = $user->get($table->displayField());
        } catch (RecordNotFoundException $e) {
            $result['displayField'] = __('{0} Instance: [{1}]', $this->get('resource'), $this->get('resource_id'));
        }

        $result['url'] = [
                'plugin' => false,
                'controller' => $this->get('resource'),
                'action' => 'view',
                $this->get('resource_id')
        ];

        return $result;
    }

    /**
     * Calculate Total Score of the Survey Entry
     *
     * Calculating only `pass` status survey_results record.
     *
     * @return int|float $result of the score.
     */
    public function getTotalScore()
    {
        $result = 0;

        $answersTable = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyAnswers');
        $results = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntryQuestions');

        $query = $results->find()
            ->where([
                'survey_entry_id' => $this->get('id'),
                'status' => 'pass'
            ])
            ->contain(['SurveyResults']);

        foreach ($query as $entity) {
            foreach ($entity->get('survey_results') as $submit) {
                $answer = $answersTable->get($submit->get('survey_answer_id'));
                $result += $answer->get('score');
            }
        }

        return $result;
    }
}

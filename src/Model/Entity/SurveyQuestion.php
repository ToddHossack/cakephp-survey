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
namespace Qobo\Survey\Model\Entity;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * SurveyQuestion Entity
 *
 * @property string $id
 * @property string $survey_id
 * @property string $question
 * @property string $type
 * @property bool $active
 * @property bool $is_required
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $trashed
 *
 * @property \Qobo\Survey\Model\Entity\Survey $survey
 */
class SurveyQuestion extends Entity
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
        'id' => false,
    ];

    /**
     * Get Score of the question based on Survey Entry id
     *
     * @param string $id of the survey entries instance
     *
     * @return int|float $result;
     */
    public function getScorePerEntry(string $id)
    {
        $result = 0;

        $resultsTable = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');

        $query = $resultsTable->find()
            ->where([
                'submit_id' => $id,
                'survey_question_id' => $this->get('id'),
            ]);

        if (empty($query->count())) {
            return $result;
        }

        foreach ($query as $submit) {
            $result += $submit->get('score');
        }

        return $result;
    }

    /**
     * Retrieve related submits based on the question instance and SurveyEntries `id`
     *
     * @param string $id of the survey_entries record
     *
     * @return null|\Cake\Datasource\ResultSetInterface $result of records
     */
    public function getResultsPerEntry(string $id) : ?ResultSetInterface
    {
        $result = null;
        $resultsTable = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');

        $query = $resultsTable->find()
            ->where([
                'submit_id' => $id,
                'survey_question_id' => $this->get('id'),
            ]);

        if (empty($query->count())) {
            return $result;
        }

        $result = $query->all();

        return $result;
    }

    /**
     * Retrieve unique status of Submitted survey_results per question/entry
     *
     * @param string $entryId of survey_entries instance
     *
     * @return string $result containing unique status of the submits.
     */
    public function getSubmitStatus(string $entryId) : string
    {
        $result = 'pass';

        $resultsTable = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');

        $query = $resultsTable->find()
            ->where([
                'submit_id' => $entryId,
                'survey_question_id' => $this->get('id'),
            ]);

        if (empty($query->count())) {
            return $result;
        }

        $statuses = [];
        foreach ($query as $entity) {
            $statuses[] = $entity->get('status');
        }

        $uniqueStatus = array_unique($statuses);
        $result = array_shift($uniqueStatus);

        if (is_null($result)) {
            $result = 'pass';
        }

        return $result;
    }
}

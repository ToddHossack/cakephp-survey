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
use Qobo\Survey\Model\Entity\SurveyEntryQuestion;

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
     * @return null|\Qobo\Survey\Model\Entity\SurveyEntryQuestion $result of entry with related submits
     */
    public function getQuestionEntryResultsPerEntry(string $id): ?SurveyEntryQuestion
    {
        $result = null;
        $questionEntryTable = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntryQuestions');

        $query = $questionEntryTable->find()
            ->where([
                'survey_entry_id' => $id,
                'survey_question_id' => $this->get('id')
            ])
            ->contain(['SurveyResults']);

        if (empty($query->count())) {
            return $result;
        }

        $result = $query->first();

        return $result;
    }
}

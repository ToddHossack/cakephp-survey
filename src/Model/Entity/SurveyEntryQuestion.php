<?php
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyEntryQuestion Entity
 *
 * @property string $id
 * @property string $survey_entry_id
 * @property string $survey_question_id
 * @property string|null $status
 * @property int|null $score
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time|null $trashed
 *
 * @property \Qobo\Survey\Model\Entity\SurveyEntry $survey_entry
 * @property \Qobo\Survey\Model\Entity\SurveyQuestion $survey_question
 */
class SurveyEntryQuestion extends Entity
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
     * Retrieve Survey Result values from `survey_Results` records attached
     * via associations/contain statement.
     *
     * @param mixed[] $options containing resultField for return.
     *
     * @return mixed[] $result with values if any.
     */
    public function getSurveyResultValues(array $options = []): array
    {
        $result = [];

        $resultField = empty($options['resultField']) ? 'survey_answer_id' : $options['resultField'];

        if (empty($this->get('survey_results'))) {
            return $result;
        }

        foreach ($this->get('survey_results') as $submit) {
            $result[] = $submit->get($resultField);
        }

        return $result;
    }
}

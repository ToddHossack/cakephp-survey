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
        'id' => false,
    ];
}

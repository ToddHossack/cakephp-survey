<?php
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyResult Entity
 *
 * @property string $id
 * @property string $survey_id
 * @property string $survey_question_id
 * @property string $survey_answer_id
 * @property string $user_id
 * @property string $result
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $trashed
 *
 * @property \Qobo\Survey\Model\Entity\Survey $survey
 * @property \Qobo\Survey\Model\Entity\SurveyQuestion $survey_question
 * @property \Qobo\Survey\Model\Entity\SurveyAnswer $survey_choice
 * @property \Qobo\Survey\Model\Entity\User $user
 */
class SurveyResult extends Entity
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
        'survey_id' => true,
        'survey_question_id' => true,
        'survey_answer_id' => true,
        'user_id' => true,
        'result' => true,
        'created' => true,
        'modified' => true,
        'trashed' => true,
        'survey' => true,
        'survey_question' => true,
        'survey_answer' => true,
        'user' => true
    ];
}

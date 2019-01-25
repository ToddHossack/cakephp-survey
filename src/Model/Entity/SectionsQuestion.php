<?php
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;

/**
 * SectionsQuestion Entity
 *
 * @property string $id
 * @property string $survey_section_id
 * @property string $survey_question_id
 * @property int|null $order
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \Qobo\Survey\Model\Entity\SurveySection $survey_section
 * @property \Qobo\Survey\Model\Entity\SurveyQuestion $survey_question
 */
class SectionsQuestion extends Entity
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

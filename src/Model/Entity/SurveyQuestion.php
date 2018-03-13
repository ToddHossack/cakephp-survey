<?php
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyQuestion Entity
 *
 * @property string $id
 * @property string $survey_id
 * @property string $question
 * @property bool $active
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
        'survey_id' => true,
        'question' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'trashed' => true,
        'survey' => true
    ];
}

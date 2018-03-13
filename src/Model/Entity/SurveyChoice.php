<?php
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyChoice Entity
 *
 * @property string $id
 * @property string $survey_question_id
 * @property string $choice
 * @property string $type
 * @property string $comment
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $trashed
 */
class SurveyChoice extends Entity
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
        'survey_question_id' => true,
        'choice' => true,
        'type' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'trashed' => true
    ];
}

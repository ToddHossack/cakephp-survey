<?php
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;

/**
 * Survey Entity
 *
 * @property string $id
 * @property string $name
 * @property string $version
 * @property string $description
 * @property bool $active
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $trashed
 */
class Survey extends Entity
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
        'name' => true,
        'version' => true,
        'description' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'trashed' => true
    ];
}

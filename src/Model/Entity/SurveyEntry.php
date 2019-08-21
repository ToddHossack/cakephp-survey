<?php
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;

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
        'id' => false,
    ];

    /**
     * Return array of the resource, that contains it's url and displayfield
     *
     * @return mixed[] $result
     */
    public function _getResourceUser() : array
    {
        $result = [];
        $table = TableRegistry::getTableLocator()->get($this->get('resource'));

        if ($table instanceof Table) {
            $user = $table->get($this->get('resource_id'));
        }

        $result = [
            'displayField' => $user->get($table->displayField()),
            'url' => [
                'plugin' => false,
                'controller' => $this->get('resource'),
                'action' => 'view',
                $this->get('resource_id')
            ]
        ];

        return $result;
    }
}

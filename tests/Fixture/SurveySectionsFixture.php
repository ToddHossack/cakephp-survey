<?php
namespace Qobo\Survey\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveySectionsFixture
 *
 */
class SurveySectionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_id' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null],
        'order' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => '00000000-0000-0000-0000-000000000001',
                'survey_id' => '00000000-0000-0000-0000-000000000001',
                'name' => 'Default',
                'active' => 1,
                'order' => 1,
                'created' => '2018-01-14 16:51:57',
                'modified' => '2019-01-14 16:51:57',
                'trashed' => null
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002',
                'survey_id' => '00000000-0000-0000-0000-000000000002',
                'name' => 'Section - 1',
                'active' => 1,
                'order' => 1,
                'created' => '2018-01-14 16:51:57',
                'modified' => '2019-01-14 16:51:57',
                'trashed' => null
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000003',
                'survey_id' => '00000000-0000-0000-0000-000000000003',
                'name' => 'Section - 1',
                'active' => 1,
                'order' => 1,
                'created' => '2018-01-14 16:51:57',
                'modified' => '2019-01-14 16:51:57',
                'trashed' => null
            ],

        ];
        parent::init();
    }
}

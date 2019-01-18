<?php
namespace Qobo\Survey\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveyQuestionsFixture
 *
 */
class SurveyQuestionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reference_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'survey_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'survey_section_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'question' => ['type' => 'text', 'length' => 4294967295, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'order' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
        ],
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
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => '00000000-0000-0000-0000-000000000001',
            'survey_id' => '00000000-0000-0000-0000-000000000001',
            'survey_section_id' => '00000000-0000-0000-0000-000000000001',
            'question' => 'To be or not to be?',
            'type' => 'checkbox',
            'active' => 1,
            'created' => '2018-03-14 10:56:36',
            'modified' => '2018-03-14 10:56:36',
            'order' => 1,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000002',
            'survey_id' => '00000000-0000-0000-0000-000000000002',
            'survey_section_id' => '00000000-0000-0000-0000-000000000002',
            'question' => 'Do you agree?',
            'type' => 'checkbox',
            'active' => 1,
            'created' => '2018-03-14 10:56:36',
            'modified' => '2018-03-14 10:56:36',
            'order' => 3,
            'trashed' => null,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000003',
            'survey_id' => '00000000-0000-0000-0000-000000000002',
            'survey_section_id' => '00000000-0000-0000-0000-000000000001',
            'question' => 'Your birthdate?',
            'type' => 'date',
            'active' => 1,
            'created' => '2018-03-14 10:56:36',
            'modified' => '2018-03-14 10:56:36',
            'order' => 34,
            'trashed' => null,
        ],
    ];
}

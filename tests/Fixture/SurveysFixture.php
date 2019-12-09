<?php
namespace Qobo\Survey\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SurveysFixture
 *
 */
class SurveysFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'reference_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'version' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => 4294967295, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'parent_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'category' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'publish_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'trashed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'expiry_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
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
                'reference_id' => null,
                'name' => 'survey - 1',
                'slug' => 'survey_-_1',
                'version' => '1.0.0',
                'description' => 'test survey - 1 description',
                'active' => 1,
                'created' => '2018-03-13 12:40:24',
                'modified' => '2018-03-13 12:40:24',
                'publish_date' => null,
                'trashed' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000002',
                'reference_id' => null,
                'name' => 'Unordered Survey',
                'slug' => 'unordered_survey',
                'version' => '1.0.0',
                'description' => 'Testing unsorted survey',
                'active' => 1,
                'created' => '2018-03-13 12:40:24',
                'modified' => '2018-03-13 12:40:24',
                'publish_date' => '2019-02-03 09:00:00',
                'trashed' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000003',
                'reference_id' => null,
                'name' => 'Full Survey Sample',
                'slug' => 'full_survey_sample',
                'version' => '1.0.0',
                'description' => 'Testing unsorted survey',
                'active' => 1,
                'created' => '2018-03-13 12:40:24',
                'modified' => '2018-03-13 12:40:24',
                'publish_date' => null,
                'trashed' => null,
            ],
            [
                'id' => '00000000-0000-0000-0000-000000000004',
                'reference_id' => null,
                'name' => 'Full Survey with SurveyResults and SurveyEntry',
                'slug' => 'full_survey_sample_with_entries',
                'version' => '1.0.0',
                'description' => 'Testing Survey Submit with Survey entries',
                'active' => 1,
                'created' => '2019-08-29 12:40:24',
                'modified' => '2019-08-29 12:40:24',
                'publish_date' => null,
                'trashed' => null,
            ],
        ];

        parent::init();
    }
}

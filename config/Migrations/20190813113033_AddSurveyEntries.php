<?php
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddSurveyEntries extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('survey_entries', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('survey_id', 'uuid', [
            'default' => null,
            'null' => false,
        ])->addIndex(['survey_id']);

        $table->addColumn('resource_id', 'uuid', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('resource', 'string', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('status', 'string', [
            'default' => null,
            'null' => true,
        ])->addIndex(['status']);

        $table->addColumn('score', 'integer', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('context', 'text', [
            'default' => null,
            'limit' => MysqlAdapter::TEXT_LONG,
            'null' => true,
        ]);

        $table->addColumn('comment', 'text', [
            'default' => null,
            'limit' => MysqlAdapter::TEXT_LONG,
            'null' => true,
        ]);

        $table->addColumn('submit_date', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('trashed', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addPrimaryKey([
            'id'
        ]);

        $table->create();
    }
}

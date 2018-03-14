<?php
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateSurveyResults extends AbstractMigration
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
        $table = $this->table('survey_results', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('survey_id', 'uuid', [
            'default' => null,
            'null' => false,
        ])->addIndex(['survey_id']);

        $table->addColumn('survey_question_id', 'uuid', [
            'default' => null,
            'null' => false,
        ])->addIndex(['survey_question_id']);

        $table->addColumn('survey_answer_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('user_id', 'uuid', [
            'default' => null,
            'null' => false,
        ])->addIndex(['user_id']);

        $table->addColumn('result', 'text', [
            'default' => null,
            'limit' => MysqlAdapter::TEXT_LONG,
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
            'id',
        ]);

        $table->create();
    }
}

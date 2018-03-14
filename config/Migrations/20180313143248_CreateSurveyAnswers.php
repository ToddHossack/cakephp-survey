<?php
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateSurveyAnswers extends AbstractMigration
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
        $table = $this->table('survey_answers', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('survey_question_id', 'uuid', [
            'default' => null,
            'null' => false,
        ])->addIndex(['survey_question_id']);

        $table->addColumn('answer', 'text', [
            'default' => null,
            'limit' => MysqlAdapter::TEXT_LONG,
            'null' => false,
        ]);

        $table->addColumn('comment', 'text', [
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
            'null' => false
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

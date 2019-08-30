<?php
use Migrations\AbstractMigration;

class CreateSurveyEntryQuestions extends AbstractMigration
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
        $table = $this->table('survey_entry_questions', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('survey_entry_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('survey_question_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('status', 'string', [
            'default' => 'null',
            'null' => true,
        ]);

        $table->addColumn('score', 'integer', [
            'default' => 0,
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

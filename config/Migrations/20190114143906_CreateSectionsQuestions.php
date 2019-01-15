<?php
use Migrations\AbstractMigration;

class CreateSectionsQuestions extends AbstractMigration
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
        $table = $this->table('sections_questions', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('survey_section_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('survey_question_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('order', 'integer', [
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

        $table->addPrimaryKey([
            'id',
        ]);

        $table->create();
    }
}

<?php
use Migrations\AbstractMigration;

class AddEntryQuestionToSurveyResults extends AbstractMigration
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
        $table = $this->table('survey_results');
        $table->addColumn('survey_entry_question_id', 'uuid', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}

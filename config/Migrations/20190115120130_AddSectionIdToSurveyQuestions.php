<?php
use Migrations\AbstractMigration;

class AddSectionIdToSurveyQuestions extends AbstractMigration
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
        $table = $this->table('survey_questions');
        $table->addColumn('survey_section_id', 'uuid', [
            'default' => null,
            'null' => true,
            'after' => 'survey_id',
        ]);
        $table->update();
    }
}

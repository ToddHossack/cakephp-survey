<?php
use Migrations\AbstractMigration;

/**
 * Adding `score` field that can be specifically assigned for each record
 * when the user submits the survey and it's either calculated automatically
 * or reviewed manually
 */
class AddScoreToSurveyResults extends AbstractMigration
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

        $table->addColumn('score', 'integer', [
            'default' => 0,
            'null' => true,
        ]);

        $table->update();
    }
}

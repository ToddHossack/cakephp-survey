<?php
use Migrations\AbstractMigration;

class AlterSurveyResultsSurveyId extends AbstractMigration
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
        $table->changeColumn('survey_id', 'uuid', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}

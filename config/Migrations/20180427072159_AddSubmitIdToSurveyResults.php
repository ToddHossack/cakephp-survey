<?php
use Migrations\AbstractMigration;

class AddSubmitIdToSurveyResults extends AbstractMigration
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
        $table->addColumn('submit_id', 'uuid', [
            'default' => null,
            'null' => true,
            'after' => 'id'
        ]);
        $table->addColumn('submit_date', 'datetime', [
            'default' => null,
            'null' => true,
            'after' => 'submit_id',
        ]);
        $table->update();
    }
}

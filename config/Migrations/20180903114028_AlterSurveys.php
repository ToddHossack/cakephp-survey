<?php
use Migrations\AbstractMigration;

class AlterSurveys extends AbstractMigration
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
        $table = $this->table('surveys');
        $table->addColumn('expiry_date', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}

<?php
use Migrations\AbstractMigration;

class AddReferenceIdToSurveys extends AbstractMigration
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
        $table->addColumn('reference_id', 'string', [
            'default' => null,
            'null' => true,
            'after' => 'id'
        ])->addIndex(['reference_id'], ['name' => 'idx_reference_id']);
        $table->update();
    }
}

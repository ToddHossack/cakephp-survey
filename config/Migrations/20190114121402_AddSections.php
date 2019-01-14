<?php
use Migrations\AbstractMigration;

class AddSections extends AbstractMigration
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
        $table = $this->table('survey_sections', ['id' => false, 'primary_key' => ['id']]);
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('survey_id', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('name', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('active', 'boolean', [
            'default' => 1,
            'null' => true
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

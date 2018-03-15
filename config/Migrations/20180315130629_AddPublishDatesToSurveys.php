<?php
use Migrations\AbstractMigration;

class AddPublishDatesToSurveys extends AbstractMigration
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

        $table->addColumn('parent_id', 'uuid', [
            'default' => null,
            'null' => true,
            'after' => 'active',
        ]);
        $table->addColumn('category', 'string', [
            'default' => null,
            'null' => true,
            'after' => 'parent_id',
        ])->addIndex(['category']);

        $table->addColumn('publish_date', 'datetime', [
            'default' => null,
            'null' => true,
            'after' => 'category',
        ]);

        $table->update();
    }
}

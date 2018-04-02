<?php
use Migrations\AbstractMigration;

class AddSlugsToSurveys extends AbstractMigration
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
        $table->addColumn('slug', 'string', [
            'default' => null,
            'null' => true,
            'after' => 'name',
        ]);
        $table->update();
    }
}

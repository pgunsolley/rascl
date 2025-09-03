<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePolicies extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this
            ->table('policies', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('descriptor', 'json', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex('name', ['unique' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}

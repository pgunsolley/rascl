<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateEndpoints extends BaseMigration
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
            ->table('endpoints', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('service_id', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}

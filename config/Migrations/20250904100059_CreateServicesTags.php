<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateServicesTags extends BaseMigration
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
            ->table('services_tags', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('service_id', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('tag_id', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}

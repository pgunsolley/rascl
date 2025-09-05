<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Methods seed.
 */
class MethodsSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [];
        foreach (['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'] as $key => $val) {
            $data[] = [
                'id' => $key + 1,
                'name' => $val,
            ];
        }

        $table = $this->table('methods');
        $table->insert($data)->save();
    }
}

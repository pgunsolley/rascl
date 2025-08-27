<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PoliciesUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PoliciesUsersTable Test Case
 */
class PoliciesUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PoliciesUsersTable
     */
    protected $PoliciesUsers;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PoliciesUsers',
        'app.Policies',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PoliciesUsers') ? [] : ['className' => PoliciesUsersTable::class];
        $this->PoliciesUsers = $this->getTableLocator()->get('PoliciesUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PoliciesUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PoliciesUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PoliciesUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

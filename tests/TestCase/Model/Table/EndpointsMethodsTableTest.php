<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EndpointsMethodsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EndpointsMethodsTable Test Case
 */
class EndpointsMethodsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EndpointsMethodsTable
     */
    protected $EndpointsMethods;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.EndpointsMethods',
        'app.Endpoints',
        'app.Methods',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EndpointsMethods') ? [] : ['className' => EndpointsMethodsTable::class];
        $this->EndpointsMethods = $this->getTableLocator()->get('EndpointsMethods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EndpointsMethods);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\EndpointsMethodsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\EndpointsMethodsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

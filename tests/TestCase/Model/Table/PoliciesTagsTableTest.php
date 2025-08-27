<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PoliciesTagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PoliciesTagsTable Test Case
 */
class PoliciesTagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PoliciesTagsTable
     */
    protected $PoliciesTags;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PoliciesTags',
        'app.Policies',
        'app.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PoliciesTags') ? [] : ['className' => PoliciesTagsTable::class];
        $this->PoliciesTags = $this->getTableLocator()->get('PoliciesTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PoliciesTags);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PoliciesTagsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PoliciesTagsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

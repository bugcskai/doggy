<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DogsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DogsTable Test Case
 */
class DogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DogsTable
     */
    protected $Dogs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Dogs',
        'app.Places',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Dogs') ? [] : ['className' => DogsTable::class];
        $this->Dogs = $this->getTableLocator()->get('Dogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Dogs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\GoogleApiHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\GoogleApiHelper Test Case
 */
class GoogleApiHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\GoogleApiHelper
     */
    protected $GoogleApi;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->GoogleApi = new GoogleApiHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoogleApi);

        parent::tearDown();
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\GoogleHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\GoogleHelper Test Case
 */
class GoogleHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\GoogleHelper
     */
    protected $GoogleHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->GoogleHelper = new GoogleHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoogleHelper);

        parent::tearDown();
    }
}

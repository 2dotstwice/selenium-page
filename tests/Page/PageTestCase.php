<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Tests\Page\PageTestCase.php
 */

namespace TwoDotsTwice\Selenium\Tests\Page;

use Sauce\Sausage\WebDriverTestCase;
use TwoDotsTwice\Selenium\Page\PageTestCase as PageTestCaseTrait;

/**
 * Class PageTestCase
 * @package TwoDotsTwice\Selenium\Tests\Page
 */
class PageTestCase extends WebDriverTestCase
{
    /**
     * Use the PageTestCaseTrait so we have access to various methods for waiting for pages to load and asserting what
     * page we're on.
     */
    use PageTestCaseTrait;

    /**
     * Default timeout for this test.
     *
     * @var int
     */
    protected $timeout = 30000;

    /**
     * Browser info for SauceLabs.
     *
     * @var array
     */
    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'platform' => 'Windows 7',
                'version' => 32,
            ),
        ),
    );
}

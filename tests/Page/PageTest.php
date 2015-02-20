<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\PageTest.php
 */

namespace TwoDotsTwice\Selenium\Page;

use Sauce\Sausage\WebDriverTestCase;

/**
 * Class PageTest
 * @package TwoDotsTwice\Selenium\Page
 */
class PageTest extends WebDriverTestCase
{
    /**
     * Browser info for SauceLabs.
     *
     * @var array
     */
    public static $browsers = array(
        array(
            'browserName' => 'Firefox',
            'desiredCapabilities' => array(
                'platform' => 'Windows 7',
                'version' => 32,
            ),
        ),
    );

    /**
     * {@inheritdoc}
     */
    public function setUpPage()
    {
    }

    /**
     * Tests the Page and PageUrl classes.
     */
    public function testPageNavigation()
    {
    }
}

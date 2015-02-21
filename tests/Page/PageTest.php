<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\PageTest.php
 */

namespace TwoDotsTwice\Selenium\Page;

use Sauce\Sausage\WebDriverTestCase;

use TwoDotsTwice\Selenium\Page\GitHub\BlogPage;

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
     * GitHub blog page.
     *
     * @var BlogPage
     */
    protected $blogPage;

    /**
     * {@inheritdoc}
     */
    public function setUpPage()
    {
        $this->blogPage = new BlogPage($this);
    }

    /**
     * Tests the Page and PageUrl classes.
     */
    public function testPageNavigation()
    {
        $this->blogPage->go();
        $this->blogPage->waitUntilLoaded(30000);
    }
}

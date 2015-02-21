<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\PageTest.php
 */

namespace TwoDotsTwice\Selenium\Page;

use Sauce\Sausage\WebDriverTestCase;

use TwoDotsTwice\Selenium\Page\GitHub\BlogPage;
use TwoDotsTwice\Selenium\Page\GitHub\RepositoryPage;

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
     * Default timeout for this test.
     *
     * @var int
     */
    protected $timeout = 30000;

    /**
     * Tests the Page and PageUrl classes.
     */
    public function testPageNavigation()
    {
        // Go to a page with a fixed path.
        $blogPage = new BlogPage($this);
        $blogPage->go();
        $blogPage->waitUntilLoaded($this->timeout);

        // Reload the page with a fixed path.
        $blogPage->reload();
        $blogPage->waitUntilLoaded($this->timeout);
    }

    /**
     * Tests the path arguments for pages with dynamic paths.
     */
    public function testPathArguments()
    {
        // Go to a page with a dynamic path.
        $repositoryPage = new RepositoryPage($this);
        $repositoryPage->go(array(
            '%account' => '2dotstwice',
            '%repository' => 'selenium-page',
        ));
        $repositoryPage->waitUntilLoaded($this->timeout);

        // Reload the page with a dynamic path.
        $repositoryPage->reload();
        $repositoryPage->waitUntilLoaded($this->timeout);
    }
}

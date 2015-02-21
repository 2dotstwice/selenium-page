<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Tests\Page\PageTest.php
 */

namespace TwoDotsTwice\Selenium\Tests\Page;

use Sauce\Sausage\WebDriverTestCase;

use TwoDotsTwice\Selenium\Tests\Page\GitHub\BlogPage;
use TwoDotsTwice\Selenium\Tests\Page\GitHub\RepositoryPage;

/**
 * Class PageTest
 * @package TwoDotsTwice\Selenium\Tests\Page
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
            'browserName' => 'firefox',
            'local' => true,
            'desiredCapabilities' => array(
                'version' => 'local',
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

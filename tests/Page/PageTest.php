<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Tests\Page\PageTest.php
 */

namespace TwoDotsTwice\Selenium\Tests\Page;

use TwoDotsTwice\Selenium\Tests\Page\GitHub\BlogPage;
use TwoDotsTwice\Selenium\Tests\Page\GitHub\RepositoryPage;

/**
 * Class PageTest
 * @package TwoDotsTwice\Selenium\Tests\Page
 */
class PageTest extends PageTestCase
{
    /**
     * Tests the Page and PageUrl classes.
     */
    public function testPageNavigation()
    {
        // Go to a page with a fixed path.
        $blogPage = new BlogPage($this);
        $blogPage->go();
        $this->assertPageArrival($blogPage, $this->timeout);

        // Reload the page with a fixed path.
        $blogPage->reload();
        $this->assertPageArrival($blogPage, $this->timeout);
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
        $this->assertPageArrival($repositoryPage, $this->timeout);

        // Reload the page with a dynamic path.
        $repositoryPage->reload();
        $this->assertPageArrival($repositoryPage, $this->timeout);
    }
}

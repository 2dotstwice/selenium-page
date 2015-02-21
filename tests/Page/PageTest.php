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
     * GitHub blog page.
     *
     * @var BlogPage
     */
    protected $blogPage;

    /**
     * GitHub repository page.
     *
     * @var RepositoryPage
     */
    protected $repositoryPage;

    /**
     * {@inheritdoc}
     */
    public function setUpPage()
    {
        $this->blogPage = new BlogPage($this);
        $this->repositoryPage = new RepositoryPage($this);
    }

    /**
     * Tests the Page and PageUrl classes.
     */
    public function testPageNavigation()
    {
        $timeout = 30000;

        // Go to a page with a fixed path.
        $this->blogPage->go();
        $this->blogPage->waitUntilLoaded($timeout);

        // Reload the page with a fixed path.
        $this->blogPage->reload();
        $this->blogPage->waitUntilLoaded($timeout);

        // Go to a page with a dynamic path.
        $this->repositoryPage->go(array(
            '%account' => '2dotstwice',
            '%repository' => 'selenium-page',
        ));
        $this->repositoryPage->waitUntilLoaded($timeout);
    }
}

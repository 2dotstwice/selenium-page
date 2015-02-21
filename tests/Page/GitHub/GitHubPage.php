<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\GitHub\GitHubPage.
 */

namespace TwoDotsTwice\Selenium\Page\GitHub;

use TwoDotsTwice\Selenium\Page\Page;

/**
 * Class GitHubPage
 * @package TwoDotsTwice\Selenium\Page\GitHub
 */
abstract class GitHubPage extends Page
{
    /**
     * Page path.
     *
     * @var string
     */
    protected $path;

    /**
     * Constructs a new GitHubPage object.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase $testCase
     *   Selenium 2 test case required to interact with the browser.
     */
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $testCase)
    {
        $url = new GitHubPageUrl($this->path);
        parent::__construct($testCase, $url);
    }
}

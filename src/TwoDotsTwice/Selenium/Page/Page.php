<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\Page.
 */

namespace TwoDotsTwice\Selenium\Page;

/**
 * Class Page
 * @package TwoDotsTwice\Selenium\Page
 *
 * Base class for implementing the Page Object pattern.
 */
abstract class Page
{
    /**
     * Selenium 2 test case object used to interact with the browser.
     *
     * @var \PHPUnit_Extensions_Selenium2TestCase
     */
    protected $testCase;

    /**
     * Page url object which contains a base url and path.
     *
     * @var PageUrlInterface
     */
    protected $url;

    /**
     * Constructs a new Page object.
     */
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Navigates to the page.
     */
    public function go()
    {
        $url = $this->url->getAbsoluteUrl();
        $this->testCase->url($url);
    }
}

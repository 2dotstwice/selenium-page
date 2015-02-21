<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\Page.
 */

namespace TwoDotsTwice\Selenium\Page;

use TwoDotsTwice\Selenium\Element\Element;

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
     * Page url object.
     *
     * @var PageUrl
     */
    protected $url;

    /**
     * Body element on the page.
     *
     * @var Element
     */
    protected $body = null;

    /**
     * Constructs a new Page object.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase $testCase
     *   Selenium 2 test case required to interact with the browser.
     * @param PageUrl $url
     *   Page url.
     */
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $testCase, PageUrl $url)
    {
        $this->testCase = $testCase;
        $this->url = $url;
    }

    /**
     * Navigates to the page.
     *
     * @param array $arguments
     *   Path arguments to pass to the PageUrl object before constructing the absolute url.
     */
    public function go($arguments = array())
    {
        $this->url->setPathArguments($arguments);
        $this->testCase->url((string) $this->url);
    }

    /**
     * Reloads the page.
     */
    public function reload()
    {
        $this->go($this->url->getPathArguments());
    }

    /**
     * Waits until the page is loaded.
     *
     * @param int $timeout
     *   Maximum time to wait for the old body to go stale or the new body to load, in milliseconds.
     */
    public function waitUntilLoaded($timeout)
    {
        // Check if the body has been set before, which would indicate the page has been loaded before.
        if (!empty($this->body)) {
            $body = $this->body;

            // Wait until clicking the old body element throws an exception, which indicates that it's no longer present
            // on the page.
            $this->testCase->waitUntil(function () use ($body) {
                try {
                    $body->click();
                    return null;
                } catch (\PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e) {
                    return true;
                }
            }, $timeout);
        }

        // Wait until the new body element is present and store it in case the page is reloaded in the future.
        $testCase = $this->testCase;
        $this->body = $this->testCase->waitUntil(function () use ($testCase) {
            $criteria = $testCase->using('xpath')->value('//body');
            return Element::find($testCase, $criteria);
        }, $timeout);
    }

    /**
     * Returns the body element on the page.
     *
     * @return Element
     *   Body element on the page.
     */
    public function getBody()
    {
        return $this->body;
    }
}

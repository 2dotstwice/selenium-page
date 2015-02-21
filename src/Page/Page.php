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
     * Page url object which contains a base url and path.
     *
     * @var PageUrlInterface
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
     * @param PageUrlInterface $url
     *   Page url.
     */
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $testCase, PageUrlInterface $url)
    {
        $this->testCase = $testCase;
        $this->url = $url;
    }

    /**
     * Navigates to the page.
     */
    public function go()
    {
        $url = $this->url->getAbsoluteUrl();
        $this->testCase->url($url);
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
        $criteria = $this->testCase->using('xpath')->value('//body');
        $this->body = Element::waitUntilFound($this->testCase, $criteria, $timeout);
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

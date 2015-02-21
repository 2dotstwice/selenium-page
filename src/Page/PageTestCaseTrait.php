<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\PageTestCaseTrait.
 */

namespace TwoDotsTwice\Selenium\Page;

/**
 * Class PageTestCaseTrait
 *
 * Should only be used on \PHPUnit_Extensions_Selenium2TestCase classes.
 *
 * @package TwoDotsTwice\Selenium\Page
 */
trait PageTestCaseTrait
{
    /**
     * Waits until a page has been loaded.
     *
     * @param Page $page
     *   The page that needs to be loaded.
     * @param int $timeout
     *   Maximum time to wait. Leave empty to use the test case's default timeout.
     */
    public function waitUntilLoaded(Page $page, $timeout = null)
    {
        /* @var \PHPUnit_Extensions_Selenium2TestCase $this */
        // Check if the body has been set before, which would indicate the page has been loaded before.
        $body = $page->getBody();
        if (!is_null($body)) {
            // Wait until clicking the old body element throws an exception, which indicates that it's no longer present
            // on the page.
            $this->waitUntil(function () use ($body) {
                try {
                    $body->click();
                    return null;
                } catch (\PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e) {
                    return true;
                }
            }, $timeout);
        }

        $this->waitUntil(function () use ($page) {
            return $page->findBody();
        }, $timeout);
    }

    /**
     * Asserts that the path of a given page matches the path of a given url.
     *
     * @param PageUrl $pageUrl
     *   Expected page url.
     * @param string $url
     *   Actual url. Leave empty to use the browser's current url.
     */
    public function assertPagePath(PageUrl $pageUrl, $url = null)
    {
        /* @var \PHPUnit_Extensions_Selenium2TestCase $this */
        if (is_null($url)) {
            $url = $this->url();
        }
        $urlComponents = parse_url($url);
        $path = $urlComponents['path'];
        $this->assertTrue($pageUrl->checkPath($path));
    }

    /**
     * Asserts that the test has arrived on a given page.
     *
     * Waits until the page is loaded before asserting that the test is on the correct page path.
     *
     * @param Page $page
     *   Page that the test should arrive on.
     * @param int $timeout
     *   Maximum time to wait for the page to load. Leave empty to use the test case's default timeout.
     */
    public function assertPageArrival(Page $page, $timeout = null)
    {
        $this->waitUntilLoaded($page, $timeout);
        $this->assertPagePath($page->getUrl());
    }
}

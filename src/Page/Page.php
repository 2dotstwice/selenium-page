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
     * Returns the url of the page.
     *
     * @return PageUrl
     *   Url of the page.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns the body element of the page.
     *
     * @return Element
     *   Body element on the page.
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Attempts to find the body element of the page.
     *
     * If found, it will update the body property of this class.
     *
     * @param Element|null
     *   Body element of the page, or null if not found.
     */
    public function findBody()
    {
        $criteria = $this->testCase->using('xpath')->value('//body');
        $body = Element::find($this->testCase, $criteria);

        if (!is_null($body)) {
            $this->body = $body;
        }

        return $body;
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
}

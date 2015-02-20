<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\PageUrl.
 */

namespace TwoDotsTwice\Selenium\Page;

/**
 * Class PageUrl
 * @package TwoDotsTwice\Selenium\Page\PageUrl
 */
class PageUrl implements PageUrlInterface
{
    /**
     * Base url.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Path.
     *
     * @var string
     */
    protected $path;

    /**
     * Constructs a new PageUrl object.
     */
    public function __construct($baseUrl, $path)
    {
        $this->setBaseUrl($baseUrl);
        $this->setPath($path);
    }

    /**
     * Sets the base url of the page.
     *
     * @param string $baseUrl
     *   Base url.
     */
    public function setBaseUrl($baseUrl)
    {
        // Make sure the base url has a trailing slash.
        if (substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }

        $this->baseUrl = $baseUrl;
    }

    /**
     * Returns the base url of the page.
     *
     * @return string
     *   The page's base url, with a trailing slash.
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Sets the path of the page.
     *
     * @param string $path
     *   Path.
     */
    public function setPath($path) {
        // Make sure the path does not start or end with a slash.
        $path = trim($path, '/');
        $this->path = $path;
    }

    /**
     * Returns the path of page.
     *
     * @return string
     *   The page's path, without slashes in front or at the end.
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getAbsoluteUrl()
    {
        return $this->getBaseUrl() . $this->getPath();
    }
}


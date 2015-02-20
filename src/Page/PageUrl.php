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
abstract class PageUrl implements PageUrlInterface
{
    /**
     * Base url.
     *
     * Should always end with a trailing slash.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Path.
     *
     * Should not start or end with a slash.
     *
     * @var string
     */
    protected $path;

    /**
     * Constructs a new PageUrl object.
     *
     * @param string $path
     *   Path of the page.
     */
    public function __construct($path)
    {
        $this->setPath($path);
    }

    /**
     * Returns the base url of the page.
     *
     * @return string
     *   The page's base url, with a trailing slash.
     */
    public function getBaseUrl()
    {
        // Make sure the base url ends with a slash.
        if (substr($this->baseUrl, -1) !== '/') {
            return $this->baseUrl . '/';
        } else {
            return $this->baseUrl;
        }
    }

    /**
     * Sets the path of the page.
     *
     * @param string $path
     *   Path.
     */
    public function setPath($path)
    {
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

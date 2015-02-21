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
abstract class PageUrl
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
     * May contain placeholders for path arguments. Each placeholder should start with a %.
     *
     * @var string
     */
    protected $path;

    /**
     * Path arguments, keyed by their placeholder (including the %).
     *
     * @var string[]
     */
    protected $pathArguments = array();

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
     * Sets the path arguments used to replace the placeholders in the path.
     *
     * @param string[] $arguments
     *   Path arguments, keyed by their placeholder (starting with a %).
     */
    public function setPathArguments($arguments)
    {
        if (is_array($arguments)) {
            // Make sure each argument's placeholder starts with a %.
            foreach ($arguments as $placeholder => $argument) {
                if (substr($placeholder, 0, 1) !== '%') {
                    unset($arguments[$placeholder]);
                    $arguments['%' . $placeholder] = $argument;
                }
            }
            $this->pathArguments = $arguments;
        }
    }

    /**
     * Returns the path arguments.
     *
     * @return string[]
     *   Path arguments, keyed by their placeholder (starting with a %).
     */
    public function getPathArguments()
    {
        return $this->pathArguments;
    }

    /**
     * Returns the path, in which any placeholders are replaced with the corresponding arguments.
     *
     * @return string
     *   Path with arguments instead of placeholders.
     */
    public function getPathWithArguments()
    {
        $path = $this->getPath();
        foreach ($this->getPathArguments() as $placeholder => $argument) {
            $path = str_replace($placeholder, $argument, $path);
        }
        return $path;
    }

    /**
     * Returns the complete url, including path arguments.
     *
     * @return string
     *   Complete url, including path arguments.
     */
    public function getUrl()
    {
        return $this->getBaseUrl() . $this->getPathWithArguments();
    }

    /**
     * Converts the object to a string, returning the complete url.
     */
    public function __toString()
    {
        return $this->getUrl();
    }
}

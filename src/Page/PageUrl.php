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
     * Returns a specific path argument, based on the placeholder's name.
     *
     * @param string $placeholder
     *   Placeholder name for the argument.
     *
     * @return string|bool
     *   Path argument, or false if the argument is not set.
     */
    public function getPathArgument($placeholder)
    {
        if (!empty($this->pathArguments[$placeholder])) {
            return $this->pathArguments[$placeholder];
        }
        return false;
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
     * Checks that a given path matches the path of this url.
     *
     * @param string $path
     *   Path to check.
     * @param bool $checkArguments
     *   If true the arguments will also be compared. Defaults to false.
     *
     * @return bool
     *   True if the path matches, false otherwise.
     */
    public function checkPath($path, $checkLength = true, $checkArguments = false)
    {
        // Trim the path of any slashes at the start or end.
        $path = trim($path, '/');

        // Get arrays of individual path components.
        $actualPathComponents = explode('/', $path);
        $expectedPathComponents = explode('/', $this->getPath());

        // If the expected path is longer than the actual path we need to check, the paths don't match.
        if (count($expectedPathComponents) > count($actualPathComponents)) {
            return false;
        }

        // If the actual path we need to check is longer than the expected path, the path's don't match unless
        // explicitly allowed.
        if (count($expectedPathComponents) < count($actualPathComponents) && $checkLength) {
            return false;
        }

        // Loop over each component of the expected path.
        foreach ($expectedPathComponents as $index => $expectedPathComponent) {
            // Get the corresponding component from the path we have to check.
            $actualPathComponent = $actualPathComponents[$index];

            // Determine whether it's a placeholder or not.
            $isPlaceholder = (substr($expectedPathComponent, 0, 1) == '%');

            // If it's a placeholder, check if an argument has been set.
            $argument = $this->getPathArgument($expectedPathComponent);

            // If no argument has been set, it may be possible that the placeholder is not actually a placeholder but
            // just a part of the path that starts with a % by coincidence.
            if ($argument === false) {
                $isPlaceholder = false;
            }

            // If it's a placeholder, and we have to check the arguments as well, and the arguments don't match, the
            // paths don't match.
            if ($isPlaceholder && $checkArguments && $argument != $actualPathComponent) {
                return false;
            }

            // If it's not a placeholder, simply compare both components. If they don't match, the paths don't match.
            if (!$isPlaceholder && $actualPathComponent != $expectedPathComponent) {
                return false;
            }
        }

        // If no checks have failed until now, the paths match.
        return true;
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

<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\PageUrlInterface.
 */

namespace TwoDotsTwice\Selenium\Page;

/**
 * Interface PageUrlInterface
 * @package TwoDotsTwice\Selenium\Page
 *
 * A page url should basically consist of a base url and a path, but in some
 * cases it may need to contain more info like scheme, port number, query, ...
 */
interface PageUrlInterface
{
    /**
     * Returns the absolute url of the page.
     *
     * @return string
     *   Absolute url.
     */
    public function getAbsoluteUrl();
}
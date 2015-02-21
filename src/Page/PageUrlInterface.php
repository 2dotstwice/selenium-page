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
 * A page url should at least have an absolute url, but may in some cases also contain separate properties of methods
 * for more detailed information about the scheme, domain name, query, ...
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

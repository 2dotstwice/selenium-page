<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Page\GitHub\RepositoryPage.
 */

namespace TwoDotsTwice\Selenium\Page\GitHub;

/**
 * Class RepositoryPage
 * @package TwoDotsTwice\Selenium\Page\GitHub
 */
class RepositoryPage extends GitHubPage
{
    /**
     * {@inheritdoc}
     */
    protected $path = '%account/%repository';
}

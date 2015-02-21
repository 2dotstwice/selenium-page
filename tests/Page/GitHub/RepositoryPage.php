<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Tests\Page\GitHub\RepositoryPage.
 */

namespace TwoDotsTwice\Selenium\Tests\Page\GitHub;

/**
 * Class RepositoryPage
 * @package TwoDotsTwice\Selenium\Tests\Page\GitHub
 */
class RepositoryPage extends GitHubPage
{
    /**
     * {@inheritdoc}
     */
    protected $path = '%account/%repository';
}

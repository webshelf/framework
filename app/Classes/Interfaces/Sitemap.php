<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 22/05/2016
 * Time: 01:07.
 */

namespace App\Classes\Interfaces;

use App\Classes\SitemapGenerator;

/**
 * Interface SitemappableInterface.
 */
interface Sitemap
{
    /**
     * The sitemap function allows plugins to quickly and effectively
     * show their content for search engines in a modular way.
     *
     * @param SitemapGenerator $sitemap
     * @return SitemapGenerator
     */
    public function sitemap(SitemapGenerator $sitemap);
}

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
interface SitemappableInterface
{
    /**
     * The sitemap function allows plugins to quickly and effectively
     * create and store new content for the SEO Sitemap Controller.
     *
     * @param SitemapGenerator $sitemap
     * @return SitemapGenerator
     */
    public function sitemap(SitemapGenerator $sitemap);
}

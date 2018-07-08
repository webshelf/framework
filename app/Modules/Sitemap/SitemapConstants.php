<?php

namespace App\Modules\Sitemap;

/**
 * Class SitemapConstants
 *
 * @package App\Modules\Sitemap
 */
class SitemapConstants
{
    /**
     * How frequently the page is likely to change.
     * This value provides general information to search engines
     * and may not correlate exactly to how often they crawl the
     * page.
     */
    const FREQUENCY_ALWAYS = 'always';
    const FREQUENCY_HOURLY = 'hourly';
    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';
    const FREQUENCY_MONTHLY = 'monthly';
    const FREQUENCY_YEARLY = 'yearly';
    const FREQUENCY_NEVER = 'never';

    /**
     * The priority of this URL relative to other URLs on your site.
     * Valid values range from 0.0 to 1.0. This value does not affect
     * how your pages are compared to pages on other sites—it only
     * lets the search engines know which pages you deem most
     * important for the crawlers.
     */
    const PRIORITY_HIGHEST = 1.0;
    const PRIORITY_HIGH = 0.8;
    const PRIORITY_NORMAL = 0.5;
    const PRIORITY_LOW = 0.3;
    const PRIORITY_LOWEST = 0.1;
    const PRIORITY_NONE = 0.0;
}
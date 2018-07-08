<?php

namespace App\Modules\Sitemap;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class SitemapGenerator.
 */
class SitemapGenerator
{
    /**
     * @var Collection
     */
    protected $items;

    /**
     * SitemapGenerator constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->items = $collection;
    }

    /**
     * Add a sitemap item to the collection.
     * @param string $location
     * @return SitemapGenerator
     */
    public function add(string $location)
    {
        $this->items->push(['loc' => $location]);

        return $this;
    }

    /**
     * The date of last modification of the file.
     *
     * @param Carbon $datetime
     *
     * @return SitemapGenerator
     */
    public function modified(Carbon $datetime)
    {
        $this->items->push(array_merge($this->items->pop(), ['lastmod' => $datetime->format('Y-m-d')]));

        return $this;
    }

    /**
     * The frequency of the file to be checked for changes.
     *
     * @param string $frequency
     *
     * @return SitemapGenerator
     */
    public function withFrequency(string $frequency)
    {
        $this->items->push(array_merge($this->items->pop(), ['changefreq' => $frequency]));

        return $this;
    }

    /**
     * Set the priority of the file to be read or indexed.
     *
     * @param int $priority
     *
     * @return SitemapGenerator
     */
    public function andPriority(int $priority)
    {
        $this->items->push(array_merge($this->items->pop(), ['priority' => $priority]));

        return $this;
    }

    /**
     * Return all the current sitemap mappings.
     *
     * @return Collection
     */
    public function collection()
    {
        return $this->items;
    }
}

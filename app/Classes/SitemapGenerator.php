<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 22/05/2016
 * Time: 07:50.
 */

namespace App\Classes;

/**
 * This is the second version of our Sitemap Generation Class.
 * This allows you to store the data before returning and lets you
 * decide what you want to do with it, which allows you to create
 * for example,  an array or xml as required. (greater control).
 *
 * Class SitemapGenerator
 */
class SitemapGenerator
{
    /**
     * Data for the sitemap to work upon.
     *
     * @var array
     */
    private $data = [];

    /**
     * Store a sample of data to the sitemap generator for usage later on.
     *
     * @param $url_location           - The url where the item can be found or viewed.
     * @param null $last_modified     - The date at which the piece was last modified. (allows model timestamps).
     * @param null $change_frequency  - Define how often this should be checked by SEO.
     * @param null $priority          - Priorty of importance that the piece is brought to SEO attention.
     */
    public function store($url_location, $last_modified = null, $change_frequency = null, $priority = null)
    {
        $this->data[] = new SitemapGeneratorDataObject($url_location, $last_modified, $change_frequency, $priority);
    }

    /**
     * Turns the stored data into a readable and usable xml for SEO Optimization.
     *
     * @return string
     */
    public function generateXML()
    {
        // headers for xml documentation type reading.
        $document = '<?xml version="1.0" encoding="UTF-8"?>';

        $document .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        // create xml tags from the stored class data.
        foreach ($this->data as $data) {
            /* @var SitemapGeneratorDataObject $data */
            $document .= '<url>';

            $document .= $data->url_location ? '<loc>'.$data->url_location.'</loc>' : null;

            $document .= $data->last_modified ? '<lastmod>'.$data->last_modified.'</lastmod>' : null;

            $document .= $data->change_frequency ? '<changefreq>'.$data->change_frequency.'</changefreq>' : null;

            $document .= $data->priority ? '<priority>'.$data->priority.'</priority>' : null;

            $document .= '</url>';
        }

        $document .= '</urlset>';

        return $document;
    }

    /**
     * Turns the stored data into a usable array in which can be used for user reading and browsing.
     *
     * @return array
     */
    public function generateArray()
    {
        $document = [];

        /** @var SitemapGeneratorDataObject $data */
        foreach ($this->data as $data) {
            $document[] = ['url_location'=>$data->url_location, 'last_modified'=>$data->last_modified, 'change_frequency'=>$data->change_frequency, 'priority'=>$data->priority];
        }

        return $document;
    }
}

/**
 * Class SitemapGeneratorDataObject.
 */
class SitemapGeneratorDataObject
{
    public $url_location;
    public $last_modified;
    public $change_frequency;
    public $priority;

    public function __construct($url_location, $last_modified, $change_frequency, $priority)
    {
        $this->url_location = $url_location;
        $this->last_modified = $last_modified->format('Y-m-d');
        $this->change_frequency = $change_frequency;
        $this->priority = $priority;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 24/12/2016
 * Time: 16:08.
 */

namespace App\Classes\Library\PageLoading\Loader;

use App\Model\Page;
use Illuminate\Support\Collection;
use App\Classes\Library\PageLoading\FrontPage;
use App\Classes\Library\PageLoading\FrontPageView;
use App\Classes\Library\PageLoading\FrontPageBuilder;

/**
 * Class PageDataLoader.
 */
class FrontPageData extends FrontPage
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * @var FrontPageView
     */
    public $view;

    /**
     * @var FrontPageBuilder
     */
    public $build;

    /**
     * @var Collection
     */
    public $configuration;

    /**
     * FrontPageData constructor.
     *
     * @param string $title
     * @param string $description
     * @param string $keywords
     * @param string $content
     */
    public function __construct(string $title = '', string $description = '', string $keywords = '', string $content = '')
    {
        $this->page = new Page;

        $this->page->seo_title = $title;

        $this->page->seo_description = $description;

        $this->page->seo_keywords = $keywords;

        $this->page->slug = (str_slug($title));

        $this->page->content = $content;

        $this->build = new FrontPageBuilder($this->page);

        $this->configuration = new Collection;

        $this->view = new FrontPageView;
    }
}

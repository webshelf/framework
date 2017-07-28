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
 * Class FrontPageModel.
 */
class FrontPageModel extends FrontPage
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
     * FrontPageModel constructor.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;

        $this->build = new FrontPageBuilder($this->page);

        $this->configuration = new Collection;

        $this->view = new FrontPageView;
    }
}

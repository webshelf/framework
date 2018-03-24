<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:15.
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page;
use Illuminate\Support\Collection;
use App\Classes\Library\PageLoader\Coordinators\Contact;
use App\Classes\Library\PageLoader\Coordinators\Frame;
use App\Classes\Library\PageLoader\Coordinators\Plugins;
use App\Classes\Library\PageLoader\Coordinators\Social;
use App\Classes\Library\PageLoader\Coordinators\Navigation;

/**
 * Class Webpage.
 */
class Webpage
{
    /**
     * @var Page
     */
    private $page;

    /**
     * @var Navigation
     */
    public $navigation;

    /**
     * @var Frame
     */
    public $frame;

    /**
     * @var Social
     */
    public $social;

    /**
     * @var Contact
     */
    public $contact;

    /**
     * @var Plugins
     */
    public $plugins;

    /**
     * @param Page $model
     * @param Collection $navigationRepository
     */
    public function __construct(Page $model, Collection $navigationRepository)
    {
        $this->page = $model;

        $this->frame = app(Frame::class);

        $this->social = app(Social::class);

        $this->contact = app(Contact::class);

        $this->plugins = app(Plugins::class);

        $this->navigation = new Navigation($model, $navigationRepository);
    }

    public function header()
    {
        return $this->page->name();
    }

    /**
     * @return mixed
     */
    public function keywords()
    {
        return $this->page->seo_keywords ?: settings()->getValue('page_keywords');
    }

    /**
     * @return mixed
     */
    public function description()
    {
        return $this->page->seo_description ?: settings()->getValue('page_description');
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->page->content;
    }

    public function title()
    {
        if (settings()->getValue('seo_text') != '') {
            if (settings()->getValue('seo_position') == 'right') {
                return ucfirst($this->page->seo_title) . ' ' . settings()->getValue('seo_separator') . ' ' . settings()->getValue('seo_text');
            } else {
                return settings()->getValue('seo_text') . ' ' . settings()->getValue('seo_separator') . ' ' . ucfirst($this->page->seo_title);
            }
        }

        return ucfirst($this->page->seo_title);
    }
}

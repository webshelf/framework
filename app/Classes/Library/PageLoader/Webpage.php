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
use App\Classes\Library\PageLoader\Coordinators\Frame;
use App\Classes\Library\PageLoader\Coordinators\Social;
use App\Classes\Library\PageLoader\Coordinators\Contact;
use App\Classes\Library\PageLoader\Coordinators\Navigation;

/**
 * Class Webpage.
 *
 * @property \Illuminate\Database\Eloquent\Collection $articles
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
     * @param Page $model
     * @param Collection $navigationRepository
     */
    public function __construct(Page $model, Collection $navigationRepository)
    {
        $this->page = $model;

        $this->frame = app(Frame::class);

        $this->social = app(Social::class);

        $this->contact = app(Contact::class);

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
        return $this->page->seo_keywords ?: config('website.tag.keywords.default');
    }

    /**
     * @return mixed
     */
    public function description()
    {
        return $this->page->seo_description ?: config('website.tag.description.default');
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
        if (config()->has('website.tag.title.position')) {
            if (config('website.tag.title.position') == 'right') {
                return ucfirst($this->page->seo_title).' '. config('website.tag.title.separator') . ' ' . config('website.tag.title.text');
            } else {
                return config('website.tag.title.text') .' '. config('website.tag.title.separator') .' '.ucfirst($this->page->seo_title);
            }
        }

        return ucfirst($this->page->seo_title);
    }
}

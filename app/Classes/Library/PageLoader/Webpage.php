<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:15.
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page as Model;
use App\Classes\SettingsManager;
use Illuminate\Support\Collection;
use App\Classes\Library\PageLoader\Cordinators\Page;
use App\Classes\Library\PageLoader\Cordinators\Site;
use App\Classes\Library\PageLoader\Cordinators\Contact;
use App\Classes\Library\PageLoader\Cordinators\Collections;

/**
 * Class Webpage.
 */
class Webpage
{
    /**
     * @var Page
     */
    public $page;

    /**
     * @var Contact
     */
    public $contact;

    /**
     * @var Site
     */
    public $site;

    /**
     * @var Collections
     */
    public $collections;

    /**
     * @param Model $model
     * @param Collection $navigationRepository
     */
    public function __construct(Model $model, Collection $navigationRepository)
    {
        $settings = app(SettingsManager::class);
        $navigation = new Navigation($navigationRepository);

        $this->page = new Page($model);
        $this->contact = new Contact($settings);
        $this->site = new Site($settings);
        $this->collections = new Collections($model, $navigation);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:12.
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page;
use App\Plugins\Pages\Model\PageOptions;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\ErrorController;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class Frontpage.
 */
class Frontpage
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var Webpage
     */
    private $webpage;

    /**
     * @var Page
     */
    private $model;

    /**
     * Frontpage constructor.
     * @param Page $model
     * @param Collection $navigationRepository
     */
    public function __construct(Page $model, Collection $navigationRepository)
    {
        $this->response = app(ResponseFactory::class);

        $this->webpage = new Webpage($this->model = $model, $navigationRepository);
    }

    /**
     * @param string|null $template
     * @param bool $override
     * @param int $status
     * @param bool $errorResponse
     * @return Response
     */
    public function publish(string $template = null, bool $override = true, int $status = 200, bool $errorResponse = false)
    {
        if (! $errorResponse) {
            if ($this->isMaintenanceMode() && ! $this->canBypassMaintenance()) {
                return ErrorController::maintenance();
            }

            if ($this->isDisabledPage($this->model)) {
                return ErrorController::disabled();
            }
        }

        return $this->response->view($this->makeBlade($template, $override), ['webpage' => $this->webpage], $status);
    }

    /**
     * A user can disable a webpage from being viewed.
     *
     * @param Page $page
     * @return bool
     */
    private function isDisabledPage(Page $page)
    {
        return false;
    }

    /**
     * Check if the website is in maintenance mode
     * which is set by the user on the dashboard.
     *
     * @return bool
     */
    public function isMaintenanceMode()
    {
        return config('app.mode') == 'maintenance';
    }

    /**
     * Check if the current logged in user if exists,
     * can bypass the maintenance and view it offline.
     *
     * @return bool
     */
    public function canBypassMaintenance()
    {
        return auth()->check() == true;
    }

    /**
     * @param string|null $template
     * @param bool $override
     * @return string
     */
    private function makeBlade(string $template = null, bool $override = true)
    {
        if ($template == null) {
            $template = currentURI() == 'index' ? 'website::index' : 'website::page';
        }

        if ($override && view()->exists("website::plugin.{$this->model->slug}")) {
            $template = "website::plugin.{$this->model->slug}";
        }

        // if view does not exist try load from plugin?
        // if (! view()->exists("{$template}")) {
        //     $template = "plugins::articles.blade.template.index";
        // }

        return $template;
    }

    /**
     * Build a error webpage to be loaded into the framework, these are usually hardcoded
     * as the symptons usually do not allow the webpage to load from the database.
     *
     * @param string $title Title of the error.
     * @param string $description Description of the error.
     * @param string $template The error blade view to be used.
     * @param int $response The response header that will be shown.
     *
     * @return Frontpage
     */
    public static function error(string $title, string $description, string $template, int $response)
    {
        $page = new Page(['seo_title' => $title, 'seo_description' => $description]);

        return (new self($page, SELF::loadNavigationFromDB()))->publish("errors::{$template}", false, $response, true);
    }

    /**
     * Load a webpage into the framework from DB, based on its identifier.
     *
     * @param string $identifier The unique name that identifies the page in DB.
     * @param int $response The response header that will be shown.
     *
     * @return Frontpage
     */
    public static function identify(string $identifier, int $response = 200)
    {
        return self::build(app(PageRepository::class)->whereIdentifier($identifier), $response);
    }

    /**
     * Build the webpage response on the framework using a page model.
     *
     * @param Page $page The page model object that has data available.
     * @param int $response The response header that will be shown.
     *
     * @return FrontPage
     */
    public static function build(Page $page, int $response = 200, string $template = null, bool $override = true)
    {
        return (new self($page, SELF::loadNavigationFromDB()))->publish($template, $override, $response);
    }

    /**
     * Return the frontpage navigation that is generated from the database.
     *
     * @return collection Collection of menu models with thier relations
     */
    private static function loadNavigationFromDB()
    {
        return app(MenuRepository::class)->allParentsWithChildren();
    }

    /**
     * Return a drafted page without response headers.
     *
     * @return Webpage
     */
    public function draft()
    {
        return $this->webpage;
    }
}

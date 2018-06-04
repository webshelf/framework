<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:12.
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\ErrorController;
use App\Classes\Repositories\MenuRepository;
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
        return ! $page->hasOption('public');
    }

    /**
     * Check if the website is in maintenance mode
     * which is set by the user on the dashboard.
     *
     * @return bool
     */
    public function isMaintenanceMode()
    {
        return settings()->getValue('maintenance_mode');
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

        return $template;
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $template
     * @param int $response
     * @return Response
     */
    public static function build(string $title, string $description, string $template, int $response)
    {
        $page = new Page(['seo_title' => $title, 'seo_description' => $description]);

        $navigation = app(MenuRepository::class)->allParentsWithChildren();

        return (new self($page, $navigation))->publish("errors::{$template}", false, $response, true);
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

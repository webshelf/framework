<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:12.
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page;
use App\Model\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\ErrorController;
use Illuminate\Contracts\Routing\ResponseFactory;

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

        return $this;
    }

    /**
     * @param string|null $template
     * @param int $status
     * @return Response
     */
    public function publish(string $template = null, int $status = 200)
    {
        if ($this->isMaintenanceMode()) {
            return ErrorController::maintenance();
        }

        if ($this->isDisabledPage($this->model)) {
            return ErrorController::disabled();
        }

        return $this->response->view($this->makeBlade($template), ['webpage' => $this->webpage], $status);
    }

    /**
     * A user can disable a webpage from being viewed.
     *
     * @param Page $page
     * @return bool
     */
    public function isDisabledPage(Page $page)
    {
        return $page->enabled == false;
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
        return auth()->check() == true && account()->hasRole(Role::ADMINISTRATOR);
    }

    /**
     * @param string|null $template
     * @return string
     */
    private function makeBlade(string $template = null)
    {
        if ($template == null) {
            return currentURI() == 'index' ? 'website::index' : 'website::page';
        }

        return $template;
    }
}

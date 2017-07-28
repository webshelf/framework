<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 07/01/2017
 * Time: 22:47.
 */

namespace App\Plugins\Carousels;

use Illuminate\Routing\Router;
use App\Classes\Breadcrumbs;
use App\Plugins\PluginEngine;
use Illuminate\Contracts\View\View;
use App\Classes\Interfaces\RouteableInterface;
use App\Classes\Repositories\CarouselRepository;

/**
 * Class AdminController.
 */
class AdminController extends PluginEngine implements RouteableInterface
{
    /**
     * @var CarouselRepository
     */
    private $carousels;

    /**
     * AdminController constructor.
     * @param Breadcrumbs $breadcrumbs
     * @param CarouselRepository $carousels
     */
    public function __construct(Breadcrumbs $breadcrumbs, CarouselRepository $carousels)
    {
        parent::__construct($breadcrumbs);

        $this->carousels = $carousels;
    }

    /**
     * Return a table listing of all the available sliders.
     *
     * @return View
     */
    public function index()
    {
        return $this->blade('index')->with('carousels', $this->carousels->all());
    }

    /**
     * Routes required for the plugin to operate correctly.
     * These define all available urls that require Auth, or not.
     * These are loaded on application boot time and may be cached.
     *
     * @param Router $router
     * @return Router|void
     */
    public function routes(Router $router)
    {
        $router->get('admin/carousels', $this->method('index'));
    }
}

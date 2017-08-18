<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 07/01/2017
 * Time: 22:47.
 */

namespace App\Plugins\Carousels;

use App\Plugins\PluginEngine;
use Illuminate\Contracts\View\View;
use App\Classes\Repositories\CarouselRepository;

/**
 * Class AdminController.
 */
class BackendController extends PluginEngine
{
    /**
     * @var CarouselRepository
     */
    private $carousels;

    /**
     * AdminController constructor.
     * @param CarouselRepository $carousels
     */
    public function __construct(CarouselRepository $carousels)
    {
        $this->carousels = $carousels;
    }

    /**
     * Return a table listing of all the available sliders.
     *
     * @return View
     */
    public function index()
    {
        return $this->make('index')->with('carousels', $this->carousels->all());
    }
}

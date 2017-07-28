<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/07/2016
 * Time: 20:41.
 */

namespace App\Plugins\Redirects;

use Illuminate\Routing\Router;
use App\Classes\Interfaces\RouteableInterface;
use App\Classes\Repositories\RedirectRepository;

/**
 * Class UserController.
 */
class UserController implements RouteableInterface
{
    /**
     * @var RedirectRepository
     */
    private $redirects;

    /**
     * UserController constructor.
     * @param RedirectRepository $redirects
     */
    public function __construct(RedirectRepository $redirects)
    {
        $this->redirects = $redirects;
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
        foreach ($this->redirects->all() as $redirect) {
            $router->get($redirect->from(), 'App\Http\Controllers\PageController@redirect');
        }
    }
}

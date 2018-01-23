<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 16:00.
 */

namespace App\Http\Controllers;

use App\Classes\Library\Services\Facebook;
use App\Classes\Repositories\ActivityRepository;
use App\Classes\Repositories\AuditRepository;
use App\Classes\Repositories\PluginRepository;
use App\Model\Plugin;

/**
 * Class AdminController.
 *
 * All dashboard related classes should extend this controller.
 * This controller sets the required authenticated route. !!
 */
class DashboardController extends Controller
{
    /**
     * Basic overview of the website, here its the dashboard panel.
     *
     * @param ActivityRepository $repository
     * @return \Illuminate\Contracts\View\View
     * @internal param Facebook $facebook
     */
    public function index(ActivityRepository $repository)
    {

        $plugin = (new PluginRepository(new Plugin))->whereName('articles');

        $plugin->handler->version();

        $activities = $repository->paginate(25);

        return view('dashboard::index')->with(['activities'=>$activities]);
    }
}

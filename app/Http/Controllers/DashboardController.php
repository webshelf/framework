<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 16:00.
 */

namespace App\Http\Controllers;

use DB;
use App\Classes\Library\Services\Facebook;
use App\Classes\Repositories\AgentRepository;
use App\Classes\Repositories\AuditRepository;
use Carbon\Carbon;

/**
 * Class AdminController.
 *
 * All dashboard related classes should extend this controller.
 * This controller sets the required authenticated route. !!
 */
class DashboardController extends Controller
{
    /**
     * This should be used when a dashboard view is rendered.
     * This will assign the global variables that are required for the dashboard to function correctly.
     * These values should exist on every single page. IE: HEADER BAR.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        return view();
    }

    /**
     * Basic overview of the website, here its the dashboard panel.
     *
     * @param AuditRepository $auditRepository
     * @param AgentRepository $agentRepository
     * @return \Illuminate\Contracts\View\View
     * @internal param Facebook $facebook
     */
    public function index(AuditRepository $auditRepository, AgentRepository $agentRepository)
    {

        $userChart = $agentRepository->select([
            // This aggregates the data and makes available a 'count' attribute
            DB::raw('count(id) as `count`'),
            // This throws away the timestamp portion of the date
            DB::raw('DATE(created_at) as day')
            // Group these records according to that day
        ])->groupBy('day')
            // And restrict these results to only those created in the last week
            ->where('created_at', '>=', Carbon::now()->subWeeks(1))
            ->get();

        $products = plugins()->all();
        $audits = $auditRepository->all()->sortByDesc('created_at');
        $facebook_posts = Facebook::loadPostsFrom('183404672136705', 5);

        return view('dashboard::overview')->with(['userChart'=>$userChart, 'fb_messages'=>$facebook_posts, 'products'=>$products, 'audits'=>$audits]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 16:00.
 */

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Spatie\Analytics\Period;
use App\Classes\Library\Services\Facebook;
use App\Classes\Library\Services\Analytics;

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
     * @param Analytics $analytics
     * @return \Illuminate\Contracts\View\View
     * @internal param Facebook $facebook
     */
    public function index(Analytics $analytics)
    {
        $audits = \App\Model\Audit::first();

        dd($audits->auditable()->first());

        exit();

        $products = plugins()->all();
        $facebook_posts = Facebook::loadPostsFrom('183404672136705', 5);
        $unique_visitors = $analytics->fetchVisitorsByMonth(Period::days(150))->sortBy('users');

        return view('dashboard::overview')->with(['fb_messages'=>$facebook_posts, 'products'=>$products, 'visitors'=>$unique_visitors]);
    }
}

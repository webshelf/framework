<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 24/12/2016
 * Time: 01:06.
 */

namespace App\Classes\Library\PageLoading;

use App\Model\Page;
use App\Model\Role;
use Illuminate\Support\Collection;

/**
 * Class ResponseView.
 */
class FrontPageView
{
    /**
     * Check if the website is in maintenance mode
     * which is set by the user on the dashboard.
     *
     * @return bool
     */
    public function hasMaintenance()
    {
        return settings()->getValue('maintenance_mode') == true;
    }

    /**
     * Check if the current logged in user if exists,
     * can bypass the maintenance and view it offline.
     *
     * @return bool
     */
    public function canBypassMaintenance()
    {
        return (auth()->check() == false) || (auth()->check() == true && account()->hasRole(Role::ADMINISTRATOR) == false);
    }

    /**
     * Returns the expected view by the multi tenant plugin view selector.
     *
     * This should be the only method used for returning views. (not errors)
     *
     * @param null $blade_template
     * @return mixed
     */
    public function normal(Page $page, Collection $data, $blade_template = null)
    {

        // check if the current page has a view plugin for override.
        if (view()->exists('website::plugin::'.$page->slug)) {
            return view()->make('website::plugin::'.$page->slug)->with('page', $data->toArray());
        }

        // check if a blade template of entered view exists.
        elseif ($blade_template != null && view()->exists($blade_template)) {
            return view()->make($blade_template)->with('page', $data->toArray());
        }

        // lets just return the basic page setup otherwise.
        else {
            return view()->make('website::page')->with('page', $data->toArray());
        }
    }

    /**
     * Since error codes can sometimes be built and work fluently into a website.
     * We will allow the response code to pull the page data as it should, but return
     * with an error code response for SEO Optimization.
     *
     * This should be the only method used for returning errors!
     * @param Collection $data
     * @param $template
     * @param int $response
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function response(Collection $data, $template, $response = 404)
    {
        if (is_null($template)) {
            throw new \Exception('No view has been giving to return as the response.');
        }

        if (view()->exists('errors::'.$template)) {
            return response()->view('errors::'.$template, ['page' => $data->toArray()], $response);
        }

        throw new \Exception('Unable to locate the view the error handler should use : '.$template);
    }
}

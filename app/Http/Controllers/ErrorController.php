<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/06/2016
 * Time: 00:28.
 */

namespace App\Http\Controllers;

use App\Classes\Library\PageLoading\Loader\FrontPageData;

/**
 * Class ErrorController.
 *
 * This class handles the error pages that are sent to the user.
 * This class is responsible for returning the view to the user.
 *
 * The Handler Exception class will handle what error should be called.
 *
 * Maintenance mode is called regardless of error, if the website is offline.
 */
class ErrorController extends Controller
{
    /**
     * 404 Errors will use this method to return a valid view to the user.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public static function unknown()
    {
        return (new FrontPageData('404 Error', '404 : Cannot find the page'))->without(['breadcrumbs'])->view('404', 404, true);
    }

    /**
     * Disabled pages are those that the user has recently disabled from the dashboard,
     * these are pages that have not been deleted but instead, removed from viewing.
     *
     * This should be treated like 404 errors, but we will display a better message, as
     * the link could have once existed and could in the future if ever re-enabled.
     */
    public static function disabled()
    {
        return (new FrontPageData('Page Moved', 'Page is unable to be located currently'))->without(['breadcrumbs'])->view('disabled', 404, true);
    }

    /**
     * The user can set their website to be in a maintenance mode.
     * This should display a friendly message to the end user.
     *
     * This will always be called if the website is set to maintenance mode no matter what !!!
     */
    public static function maintenance()
    {
        return (new FrontPageData('Maintenance Mode', 'The website is currently offline and will return shortly'))->without(['*'])->view('maintenance', 503, true);
    }

    /**
     * Database errors occur, and should have an easy to read
     * view for the user to interpret.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public static function database()
    {
        return (new FrontPageData('Database Connection Issue', 'There was a problem with the database and must be resolved.'))->without(['*'])->view('database', 500, true);
    }

    /**
     * Developer issues are those which the developer is at fault, this
     * will only occur if the exception is not caught by the exception handler
     * and the application can continue no further.
     *
     * @return \Illuminate\Http\Response
     */
    public static function developer()
    {
        return (new FrontPageData('Developer Issues have Occurred', 'The application was unable to handle the request and could not continue'))->without(['*'])->view('500', 500, true);
    }
}

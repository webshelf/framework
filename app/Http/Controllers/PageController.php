<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/04/2016
 * Time: 14:13.
 *
 * Updated: 20/06/2016 00:56
 */

namespace App\Http\Controllers;

use App\Events\PageWasVisited;
use App\Model\Page;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoading\FrontPage;
use App\Classes\Library\PageLoading\Loader\FrontPageModel;
use App\Plugins\Pages\Events\PageWasViewed;

/**
 * Class PageController.
 *
 * The class handles the page that will be sent back to the user.
 *
 * The FrontPageLoader class does all the work though.
 *
 * Errors are now handled in the ErrorController class.
 */
class PageController extends Controller
{
    /**
     * @var Page
     */
    private $currentPage;

    /**
     * PageController constructor.
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages)
    {
        $this->currentPage = $pages->whereName(currentURI());
    }

    /**
     * Standard page views are once that use the URL as the designated target.
     *
     * @return mixed
     * @throws \Exception
     * @internal param FrontPageLoader $pageLoader
     */
    public function index()
    {
        return $this->load((new FrontPageModel($this->currentPage)));
    }

    /**
     * Redirects must use a controller to handle the parameter, as they require a specified target.
     * @return mixed
     */
    public function redirect()
    {
        return redirect($this->currentPage->redirect->to(), 302);
    }

    /**
     * @param FrontPage $page
     * @return \Illuminate\Http\Response|mixed|\Symfony\Component\HttpFoundation\Response
     */
    private function load(FrontPage $page)
    {
        // we keep track of the hits on pages.
        // we let the event handler manage this.
        event(new PageWasVisited($this->currentPage));

        // if the current route is the homepage.
        // we should return the homepage view.
        if (currentURI() == 'index') {
            return $page->view('website::index');
        }

        // if we are not on the index page, we will
        // assume that the user is loading a standard
        // page.
        return $page->view('website::page');
    }
}

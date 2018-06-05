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

use App\Model\Page;
use App\Events\PageWasVisited;
use App\Events\WebsiteWasVisited;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use App\Classes\Library\PageLoader\Frontpage;
use App\Jobs\IncrementViews;

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
     * Redirects must use a controller to handle the parameter, as they require a specified target.
     * @return mixed
     */
    public function redirect()
    {
        return redirect($this->currentPage->redirect->to(), 302);
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
        IncrementViews::dispatch($this->currentPage);

        return Frontpage::build($this->currentPage);
    }
}

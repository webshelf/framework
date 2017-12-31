<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:12
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Frontpage
{

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Page
     */
    private $webpage;

    /**
     * Frontpage constructor.
     * @param ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->response = $responseFactory;
    }

    /**
     * @param Page $page
     * @param Collection $navigationRepository
     * @return Frontpage
     */
    public function draft(Page $page, Collection $navigationRepository)
    {
        $this->webpage = new Webpage($page, $navigationRepository);

        return $this;
    }

    /**
     * @param string $view
     * @param int $status
     * @return bool
     */
    public function publish(string $view = null, int $status = 200)
    {
        return $this->response->view($this->getBladeView(), ['webpage' => $this->webpage], $status);
    }

    /**
     * @param string|null $view
     * @return string
     */
    private function getBladeView(string $view = null)
    {
        if ($view == null)
        {
            return currentURI() == 'index' ? 'website::index' : 'website::page';
        }

        return "website::{$view}";
    }
}
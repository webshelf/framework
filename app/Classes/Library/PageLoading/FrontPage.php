<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 24/12/2016
 * Time: 00:02.
 */

namespace App\Classes\Library\PageLoading;

use App\Model\Page;
use Illuminate\Support\Collection;
use App\Http\Controllers\ErrorController;

/**
 * Class FrontPage.
 *
 * FrontPage is responsible for getting all the information for a front end request.
 */
abstract class FrontPage
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * @var FrontPageView
     */
    public $view;

    /**
     * @var FrontPageBuilder
     */
    public $build;

    /**
     * @var Collection
     */
    public $configuration;

    /**
     * Stop loading of a page element.
     *
     * - breadcrumbs, menus
     *
     * @param array $keys
     * @return $this
     */
    public function without(array $keys)
    {
        /*
         * Check if we are trying to disable all additional
         * information to the page.
         */
        if (in_array('*', $keys)) {
            $this->configuration->put('without.all', true);
        } else {
            foreach ($keys as $key) {
                $this->configuration->put('without.'.$key, true);
            }
        }

        return $this;
    }

    /**
     * Return a normal view of the web page, with suitable web response
     * This should not be used for error controllers.
     *
     * @param string $template
     * @param int $response
     * @param bool $errorResponse
     * @return \Illuminate\Http\Response|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function view(string $template, $response = null, bool $errorResponse = false)
    {
        /*
         * If an error exists, we should always return that first before
         * checking for application issues, errors can mean user
         * selected errors such as maintenance or disabled,
         * but can also result from error codes.
         */
        if ($errorResponse == true) {
            return $this->view->response($this->build(), $template, $response);
        }

        /*
         * Users can turn their site offline to change settings
         * or update existing information, authenticated
         * users can bypass this maintenance view.
         */
        if ($this->view->hasMaintenance()) {
            return ErrorController::maintenance();
        }

        /*
         * Users sometimes will remove a page, setting it to private
         * this will mean the page still exists but is not viewable
         * here we will create a disabled page showing 404 not found.
         */
        if ($this->page->isDisabled()) {
            return ErrorController::disabled();
        }

        /*
         * Return the view as a normal page.
         */
        return $this->view->normal($this->page, $this->build(), $template);
    }

    /**
     * Build the page data using configurations.
     */
    public function build()
    {
        /*
         * These are the defaults that should be shown if
         * not appended later on.
         */
        $data = collect(
            [
                'seo'         => [],
                'content'     => '',
                'menus'       => [],
                'sidebar'     => [],
                'breadcrumbs' => [],
                'contact'     => [],
                'current'     => [],
                'copyright'   => '',
            ]
        );

        /*
         * The array of data that will be used for the front
         * page, the values are hardcoded and should not
         * be changed, these first values must always
         * exist for correct functionality of the app.
         */
        $data->put('seo', $this->build->transcribe());

        /*
         * Sometimes we may require the current page attributes
         */
        $data->put('current', ['title' => $this->page->seoTitle()]);

        /*
         * These are page optional depending on what will be
         * shown to the end user.
         */
        if (! $this->configuration->has('without.all')) {
            if (! $this->configuration->has('without.content')) {
                $data->put('content', $this->build->content());
            }
            if (! $this->configuration->has('without.plugins')) {
                $data->put('plugins', $this->build->plugins());
            }
            if (! $this->configuration->has('without.menus')) {
                $data->put('menus', $this->build->menus());
            }
            if (! $this->configuration->has('without.sidebar')) {
                $data->put('sidebar', $this->build->sidebar());
            }
            if (! $this->configuration->has('without.breadcrumbs')) {
                $data->put('breadcrumbs', $this->build->breadcrumbs());
            }
            if (! $this->configuration->has('without.contact')) {
                $data->put('contact', $this->build->contact());
            }
            if (! $this->configuration->has('without.copyright')) {
                $data->put('copyright', $this->build->copyright());
            }
        }

        return $data;
    }
}

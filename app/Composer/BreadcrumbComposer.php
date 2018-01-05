<?php
/**
 * Created by PhpStorm.
 * Date: 29/04/2017
 * Time: 23:02.
 */

namespace App\Composer;

use Illuminate\View\View;
use App\Classes\Breadcrumbs;

/**
 * Class BreadcrumbComposer.
 */
class BreadcrumbComposer
{
    /**
     * The breadcrumb class implementation.
     *
     * @var Breadcrumbs
     */
    private $breadcrumbs;

    /**
     * Create a new breadcrumb composer.
     *
     * @param Breadcrumbs $breadcrumbs
     * @internal param View $view
     */
    public function __construct(Breadcrumbs $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('breadcrumbs', Breadcrumbs::fromCurrentRoute());
    }
}

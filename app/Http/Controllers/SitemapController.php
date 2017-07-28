<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 29/03/2016
 * Time: 17:59.
 */

namespace App\Http\Controllers;

use App\Model\Plugin;
use Illuminate\Contracts\View\View;
use App\Classes\SitemapGenerator;
use Illuminate\Database\Eloquent\Collection;
use App\Classes\Repositories\PluginRepository;
use App\Classes\Interfaces\SitemappableInterface;

/**
 * Class SitemapController.
 *
 * Generate the site content sitemap.xml for SEO.
 */
class SitemapController extends Controller
{
    /**
     * @var PluginRepository
     */
    private $plugins;

    /**
     * @var SitemapGenerator
     */
    private $sitemap;

    /**
     * SitemapController constructor.
     *
     * @param SitemapGenerator $sitemap
     * @param PluginRepository $plugins
     */
    public function __construct(SitemapGenerator $sitemap, PluginRepository $plugins)
    {
        $this->middleware('auth', ['only' => 'iframe']);

        $this->sitemap = $sitemap;

        $this->plugins = $plugins;
    }

    /**
     * @return View
     * @internal param PluginRepository $plugins
     */
    public function iframe()
    {
        // this is located on the dashboard.
        // set it up as a dashboard controller.
        $dashboard = app(DashboardController::class);

        $this->loadPluginSitemaps($this->plugins->allWhereActive());
        // get and create an array of all the sitemaps to be loaded
        // send to the view for display.

        return $dashboard->view()->make('dashboard::modules.sitemap.iframe')->with('sitemaps', $this->sitemap->generateArray());
    }

    /**
     * @param PluginRepository $plugins
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $this->loadPluginSitemaps($this->plugins->allWhereActive());

        return response($this->sitemap->generateXML(), 200, ['Content-Type' => 'text/xml;charset=utf-8']);
    }

    private function loadPluginSitemaps(Collection $plugins)
    {
        /** @var Plugin $plugin */
        foreach ($plugins as $plugin) {
            $controller = userPluginController($plugin->name(), null, true);

            if (class_exists($controller)) {
                if (userPluginController($plugin->name()) instanceof SitemappableInterface) {
                    $this->sitemap(userPluginController($plugin->name()));
                }
            }
        }
    }

    /**
     * Get the plugin sitemap function and its contents.
     *
     * @param SitemappableInterface $plugin
     * @return bool|mixed
     */
    private function sitemap(SitemappableInterface $plugin)
    {
        return $plugin->sitemap($this->sitemap);
    }
}

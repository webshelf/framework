<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 29/07/2017
 * Time: 00:03.
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Auth\User;

class PermissionTest extends TestCase
{
    /**
     * @test
     */
    public function view_dashboard_page()
    {
        $this->dashboardAccessTest('/admin');
    }

    /**
     * @test
     */
    public function view_pages_plugin_page()
    {
        $this->dashboardAccessTest('/admin/pages');
    }

    /**
     * @test
     */
    public function view_products_plugin_page()
    {
        $this->dashboardAccessTest('/admin/products');
    }

    /**
     * @test
     */
    public function view_menus_plugin_page()
    {
        $this->dashboardAccessTest('/admin/menus');
    }

    /**
     * @test
     */
    public function view_updates_module_page()
    {
        $this->dashboardAccessTest('/admin/updates');
    }

    /**
     * @test
     */
    public function view_settings_modules_page()
    {
        $this->dashboardAccessTest('/admin/settings');
    }

    /**
     * @test
     */
    public function view_sitemap_modules_page()
    {
        $this->dashboardAccessTest('/admin/sitemap');
    }

    /**
     * @test
     */
    public function view_filemanager_modules_page()
    {
        $this->dashboardAccessTest('/admin/filemanager');
    }

    /**
     * @test
     */
    public function view_login_page()
    {
        $this->visit('/admin/login', 200);
    }

    /**
     * @test
     */
    public function view_logout_page()
    {
        $this->visit('/admin/logout', 302, '/admin/login');
    }
}

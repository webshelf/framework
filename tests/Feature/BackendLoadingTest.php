<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 29/07/2017
 * Time: 00:03
 */

namespace Tests\Feature;

use App\Model\Account;
use Illuminate\Foundation\Auth\User;
use Tests\TestCase;

class BackendLoadingTest extends TestCase
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
    public function view_accounts_modules_page()
    {
        $this->dashboardAccessTest('/admin/accounts');
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

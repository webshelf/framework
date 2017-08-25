<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 12/10/2016
 * Time: 20:13.
 */

namespace App\Modules\Accounts;

use App\Http\Controllers\DashboardController;
use App\Modules\ModuleEngine;
use DB as Database;
use App\Classes\Email;
use App\Classes\Popup;
use App\Model\Account;
use Illuminate\Http\Request;
use App\Classes\Breadcrumbs;
use Illuminate\Contracts\View\View;
use App\Classes\Repositories\RoleRepository;
use App\Classes\Repositories\AccountRepository;

/**
 * Class Controller.
 */
class Controller extends ModuleEngine
{
    /**
     * @var AccountRepository
     */
    private $accounts;

    /**
     * @var RoleRepository
     */
    private $roles;

    /**
     * This is the dashboard controller, this should be used
     * whenever any class is going to show the dashboard to
     * the user.
     *
     * DashboardController constructor.
     * @param AccountRepository $accounts
     * @param RoleRepository $roles
     */
    public function __construct(AccountRepository $accounts, RoleRepository $roles)
    {
        $this->accounts = $accounts;

        $this->roles = $roles;
    }

    /**
     * Return all the accounts viable.
     */
    public function index()
    {
        return $this->make('index')->with('accounts', $this->accounts->all());
    }

    /**
     * Show a register email form.
     */
    public function register()
    {
        return $this->make('register')->with('roles', $this->roles->whereRolesGreaterOrEqualToMyAccount());
    }

    /**
     * Display the accounts profile data, including username, images, statistics and etc.
     *
     * @param $account_input
     * @return View
     * @internal param $email_address
     */
    public function profile($account_input)
    {
        if (is_numeric($account_input)) {
            $account = $this->accounts->whereID($account_input);
        } else {
            $account = $this->accounts->whereEmail($account_input);
        }

        if (! is_null($account)) {
            return $this->make('profile')->with('account', $account)->with('roles', $this->roles->whereRolesGreaterOrEqualToMyAccount());
        }

        // let the user know the account couldn't be loaded and redirect back to dashboard.
        popups()->add((new Popup(['message' => 'The account '.$account_input.' could not be loaded for viewing.']))->error());

        return redirect()->route('dashboard');
    }
}

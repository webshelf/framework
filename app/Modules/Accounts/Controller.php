<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 12/10/2016
 * Time: 20:13.
 */

namespace App\Modules\Accounts;

use App\Classes\Email;
use App\Model\Account;
use Illuminate\Http\Request;
use App\Modules\ModuleEngine;
use Illuminate\Contracts\View\View;
use App\Classes\Repositories\RoleRepository;
use App\Http\Controllers\DashboardController;
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
     * Form to create a new account.
     *
     * @param RoleRepository $roleRepository
     * @return Controller|View
     */
    public function create(RoleRepository $roleRepository)
    {
        return $this->make('create')->with('groups', $roleRepository->get());
    }

    /**
     * Store a new account to the database.
     *
     * @param Request $request
     * @param Account $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Account $account)
    {
        $this->validate($request, ['forename' => 'required|min:1|max:255', 'surname' => 'required|min:3|max:255', 'password' => 'required|min:3|max:255', 'email' => 'required|email', 'group' => 'required|integer']);

        $account->forename = $request['forename'];
        $account->surname = $request['surname'];
        $account->role_id = $request['group'];
        $account->email = $request['email'];
        $account->setPassword($request['password'])->save();

        return redirect()->route('admin.accounts.index');
    }
}

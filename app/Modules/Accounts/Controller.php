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

        $this->middleware(['role:administrator']);
    }

    /**
     * Return all the accounts viable.
     */
    public function index()
    {
        return $this->make('index')->with('accounts', $this->accounts->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return $this->make('form')->with(['account' => $this->accounts->whereID($id), 'roles' => $this->roles->all()]);
    }

    /**
     * Destroy the account and return the ajax response.
     *
     * @param int $id The id that should be looked up
     * @param AccountRepository $account Load the repository for looking up the ID
     * @return Response The response of the json deletion of the account.
     */
    public function destroy($id, AccountRepository $account)
    {
        $account->whereID($id)->delete();

        return response()->json(['status' => 'true', 'redirect' => route('admin.accounts.index')]);
    }

    /**
     * Form to create a new account.
     *
     * @param RoleRepository $roleRepository
     * @return Controller|View
     */
    public function create(RoleRepository $roleRepository)
    {
        return $this->make('form')->with(['account' => new Account, 'roles' => $this->roles->all()]);
    }

    /**
     * Store a new account to the database.
     *
     * @param Request $request
     * @param Account $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validate entries.
        $request->validate([
            'forename' => 'required|min:3|max:255',
            'surname'  => 'sometimes|nullable|min:3|max:255',
            'email'    => 'required|email|unique:accounts',
            'password' => 'required|confirmed|min:3|max:255',
            'role'     => 'required|string|exists:system_roles,name',
        ]);

        // store the new account data.
        $this->storeDataFrom($request, new Account);

        // redirect back to the accounts index.
        return redirect()->route('admin.accounts.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, AccountRepository $repository)
    {
        // validate entries.
        $request->validate([
            'forename' => 'required|min:3|max:255',
            'surname'  => 'sometimes|nullable|min:3|max:255',
            'email'    => "required|email|unique:accounts,email,{$id}",
            'password' => 'sometimes|nullable|confirmed|min:3|max:255',
            'role'     => 'required|string|exists:system_roles,name',
        ]);

        $this->storeDataFrom($request, $repository->whereID($id));

        return redirect()->route('admin.accounts.index');
    }

    /**
     * Store the data from the form request.
     *
     * @param Request $request
     * @return Account $account
     */
    public function storeDataFrom(Request $request, Account $account)
    {
        // Assign properties to the model.
        $account->forename = $request->input('forename');
        $account->surname = $request->input('surname');
        $account->email = $request->input('email');

        if ($request->input('password') != null) {
            $account->password = $request->input('password');
        }

        $account->save();

        // assign the role from the request.
        $account->setRole($request->input('role'));

        // return the data that was created.
        return $account;
    }
}

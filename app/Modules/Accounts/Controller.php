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
     * Once registration form is complete, it will be processed with this method.
     *
     * @param Request $request
     * @param Account $account
     * @param RoleRepository $role
     * @return \Illuminate\Http\RedirectResponse
     * @internal param RoleRepository $roleRepository
     */
    public function registration(Request $request, Account $account)
    {
        // validate the form fields with laravel validation.
        $this->validate($request, [
            'email'    => 'required|unique:accounts|max:255|email',
            'password' => 'sometimes|same:confirmed_password',
            'role_id'  => 'digits_between:1,99',
            'forename' => 'sometimes|string|max:255',
            'surname'  => 'sometimes|string|max:255',
            'address'  => 'sometimes',
            'number'   => 'sometimes',
        ], [
            'email.unique' => 'An account with this email already exists.',
            'email.required' => 'You must provide a valid email address',
        ]);

        // run the following or rollback of failure.
        Database::transaction(function () use ($account, $request) {
            // create a new account with a role and email.
            $account->setEmail($request['email'])->setVerified(false)->setRoleID($this->roles->whereID($request['role_id'])->id());

            // these are not required but could exist.
            // lets store these in the mean time, and prompt on login that they are required.
            ! $request['forename'] ?: $account->setForename($request['forename']);
            ! $request['surname'] ?: $account->setSurname($request['surname']);
            ! $request['address'] ?: $account->setAddress($request['address']);
            ! $request['number'] ?: $account->setNumber($request['number']);
            ! $request['password'] ?: $account->setPassword(bcrypt($request['password']));

            // save the account.
            $account->save();

            // email the account holder with a verification link to complete registration.
            (new Email)->to($account)->header('Account Verification')->subject('Verify and create your new account')->with('link', encrypt($account->id()))->send('email.view::register.personal');

            // notify the current account that the new account has been saved and ready for use.
            popups()->add((new Popup(['message' => 'A validation email has been sent to the designated email address.']))->success());
        });

        // redirect to the accounts index.
        return redirect()->intended(route('accounts'));
    }

    /**
     * The accounts ID is encrypted with our applications encryption code.
     * There is no expiration time on this.
     *
     * -- check if email is already verified.
     * -- check if account exists to be verified.
     * -- show a form to complete missing data if required.
     * -- If all good, verify the user and log them in to the application.
     *
     * @param $account_id
     * @internal param $account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($account_id)
    {
        $account_id = decrypt($account_id);

        if (! is_numeric($account_id)) {
            return view()->make('/');
        }

        /** @var Account $account */
        $account = $this->roles->whereID($account_id);

        if (! is_object($account) || $account->isVerified(true)) {
            dd('This verification link is no longer valid.');
        }

        if ($account->forename() == '' || $account->surname() == '' || $account->password() == '') {
            return $this->make('verification')->with('account', $account);
        }

        $account->setVerified(true)->save();

        // the user should have to login to prove identity.
        // the login should show a message saying their account was made.

        // let the user know that they have been logged in.
        // ++++ a message letting the user know, should be shown on the login screen. ++++
        popups()->add((new Popup(['message' => 'You have been automatically logged in with your new account.']))->success());

        // check if user is logged in.
        if (auth()->check()) {
            // if so, log them out :d
            auth()->logout();
        }

        // send them to the login form to log in for their first time.
        return redirect()->route('login');
    }

    /**
     * @param Request $request
     * @param AccountRepository $account
     * @internal param $account_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Request $request)
    {
        $this->validate($request, [
            'password' => 'sometimes|same:confirmed_password',
            'forename' => 'sometimes|string|max:255',
            'surname'  => 'sometimes|string|max:255',
        ]);

        $account = $this->accounts->whereID(decrypt($request['account_id']));

        // these are not required but could exist.
        // lets store these in the mean time, and prompt on login that they are required.
        ! $request['forename'] ?: $account->setForename($request['forename']);
        ! $request['surname'] ?: $account->setSurname($request['surname']);
        ! $request['address'] ?: $account->setAddress($request['address']);
        ! $request['number'] ?: $account->setNumber($request['number']);
        ! $request['password'] ?: $account->setPassword(bcrypt($request['password']));

        $account->save();

        if ($account->isVerified(false)) {
            return $this->verify($request['account_id']);
        }

        return redirect()->intended(route('dashboard'));
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

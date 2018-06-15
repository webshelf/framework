<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 12/03/2016
 * Time: 16:44.
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Model\Account;
use Illuminate\Http\Request;
use App\Events\AccountLogin;
use App\Model\AccessLog;
use App\Classes\Repositories\AccountRepository;
use App\Events\AccessAttempt;

/**
 * Class AuthController.
 */
class AuthController extends Controller
{
    /**
     * Make a request to the application for an account login.
     * This excludes user login which is based on unauthorized accounts.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {

        // Only the password and email are the only required credentials.
        $credentials = $request->only('email', 'password');

        /*
         * We do not require validation as we do not want to give away what the issue with logging in is exactly.
         * If the user does not enter the correct username or password then they will be giving a genertic error
         * message.
         */
        if (auth()->attempt($credentials, $request->has('remember'))) {

            // redirect to dashboard after login.
            return redirect()->intended(route('dashboard'));
        }

        // on login failure.
        return redirect()->intended(route('login'))->withErrors(['message' => 'Incorrect email or password.']);
    }

    /**
     * Log a user out of the application safely.
     * This is only permitted when the user clicks logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();

        return redirect()->intended(route('login'));
    }

    /**
     * Display the form to request entry.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function form()
    {
        return view()->make('dashboard::login');
    }
}

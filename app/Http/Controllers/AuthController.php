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

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->has('remember'))) {

            // log login activity.
            $this->logAgentInformation();

            // track login activity.?

            // redirec to dashboard after login.
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
        \Auth::logout();

        return redirect()->intended(route('login'));
    }

    /**
     * Display the form to request entry.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function form()
    {
        return view()->make('dashboard::modules.accounts.login');
    }

    /**
     * Sometimes we need to verify login entries.
     * Here we will assign all the fields and logs.
     *
     * @return Account
     */
    public function logAgentInformation()
    {
        account()->incrementLoginCount(1);

        account()->setIpAddress(request()->getClientIp());

        account()->setLastLogin(Carbon::now());

        account()->save();

        return account();
    }
}

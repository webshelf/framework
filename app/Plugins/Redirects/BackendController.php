<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 29/07/2016
 * Time: 13:37.
 */

namespace App\Plugins\Redirects;

use App\Classes\Popup;
use Illuminate\Http\Request;
use App\Model\Redirect;
use App\Plugins\PluginEngine;
use App\Classes\Repositories\PageRepository;
use App\Classes\Repositories\RedirectRepository;

/**
 * Class AdminController.
 */
class BackendController extends PluginEngine
{
    /**
     * @var RedirectRepository
     */
    private $redirects;

    /**
     * AdminController constructor.
     * @param RedirectRepository $redirects
     */
    public function __construct(RedirectRepository $redirects)
    {
        $this->redirects = $redirects;
    }

    /**
     * Display all redirects.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->blade('index')->with('redirects', $this->redirects->all());
    }

    /**
     * Form for creating a new redirect.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function store()
    {
        return $this->blade('make')->with('pages', app(PageRepository::class)->makeList());
    }

    /**
     * Store a new redirect to the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'redirect_from_id' => 'required|unique:redirects,from,NULL,id,deleted_at,NULL|max:255',
            'redirect_to_id'   => 'required|max:255|different:redirect_from_id,NULL,id,deleted_at,NULL',
        ], [
            'redirect_from_id.unique' => 'A redirect already existed for the requested url.',
            'redirect_to_id.different' => 'You cannot redirect to the same location as the redirect caller',
        ]);

        // you must not be able to redirect to the same page
        // redirect too many times error.

        $redirect = new Redirect;
        $redirect->setFrom($request['redirect_from_id']);
        $redirect->setTo($request['redirect_to_id']);

        account()->redirects()->save($redirect);

        popups()->add((new Popup(['message'=>'Redirect has been activated.']))->success());

        return redirect()->route('redirects');
    }

    public function ajaxDeleteID(Request $request, $id)
    {
        $redirect = $this->redirects->whereID($id);

        $redirect->delete();

        popups()->setSession($request->session())->add((new Popup(['message'=>'Redirect has been removed.']))->success());

        return response()->json(['success' => true, 'notify' => false]);
    }
}

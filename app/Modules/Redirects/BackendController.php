<?php

namespace App\Modules\Redirects;

use App\Model\Redirect;
use App\Modules\ModuleEngine;
use Illuminate\Http\Request;
use App\Classes\Repositories\PageRepository;
use App\Classes\Repositories\RedirectRepository;

/**
 * Class AdminController.
 */
class BackendController extends ModuleEngine
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
        return $this->make('index')->with('redirects', $this->redirects->withRelationship());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PageRepository $pageRepository
     * @return \Illuminate\Http\Response
     */
    public function create(PageRepository $pageRepository)
    {
        return $this->make('create')->with('pages', $pageRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->save($request, new Redirect);

        return redirect()->route('admin.redirects.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param RedirectRepository $redirectRepository
     * @param PageRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function edit($id, RedirectRepository $redirectRepository, PageRepository $repository)
    {
        return $this->make('edit')
            ->with([
                'redirect' => $redirectRepository->whereID($id),
                'pages' => $repository->all(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param RedirectRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, RedirectRepository $repository)
    {
        $this->save($request, $repository->whereID($id));

        return redirect()->route('admin.redirects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param RedirectRepository $repository
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id, RedirectRepository $repository)
    {
        $repository->whereID($id)->delete();

        return redirect()->route('admin.redirects.index');
    }

    /**
     * Save the data for the resource.
     *
     * @param Request $request
     * @param Redirect $redirect
     * @return bool
     */
    public function save(Request $request, Redirect $redirect)
    {
        $this->validate($request, [
            'redirectFromPage' => 'required|max:255',
            'redirectToPage'   => 'required|max:255|different:redirectFromPage',
        ]);

        $redirect->from = $request['redirectFromPage'];
        $redirect->to = $request['redirectToPage'];

        return $redirect->save();
    }

//    /**
//     * Form for creating a new redirect.
//     *
//     * @return \Illuminate\Contracts\View\View
//     */
//    public function store()
//    {
//        return $this->make('make')->with('pages', app(PageRepository::class)->makeList());
//    }

//    /**
//     * Store a new redirect to the database.
//     *
//     * @param Request $request
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function create(Request $request)
//    {
//        $this->validate($request, [
//            'redirect_from_id' => 'required|unique:redirects,from,NULL,id,deleted_at,NULL|max:255',
//            'redirect_to_id'   => 'required|max:255|different:redirect_from_id,NULL,id,deleted_at,NULL',
//        ], [
//            'redirect_from_id.unique' => 'A redirect already existed for the requested url.',
//            'redirect_to_id.different' => 'You cannot redirect to the same location as the redirect caller',
//        ]);
//
//        // you must not be able to redirect to the same page
//        // redirect too many times error.
//
//        $redirect = new Redirect;
//        $redirect->setFrom($request['redirect_from_id']);
//        $redirect->setTo($request['redirect_to_id']);
//
//        account()->redirects()->save($redirect);
//
//        popups()->add((new Popup(['message'=>'Redirect has been activated.']))->success());
//
//        return redirect()->route('redirects');
//    }
}

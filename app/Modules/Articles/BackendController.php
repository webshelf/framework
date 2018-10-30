<?php

namespace App\Modules\Articles;

use Carbon\Carbon;
use App\Model\Article;
use App\Model\Categories;
use Illuminate\Http\Request;
use App\Modules\ModuleEngine;
use App\Classes\Repositories\ArticleRepository;
use App\Modules\Articles\Events\ArticleCreated;
use App\Modules\Articles\Events\ArticleDeleted;
use App\Modules\Articles\Events\ArticleUpdated;
use App\Classes\Repositories\ArticleCategoryRepository;

/**
 * Class Controller.
 */
class BackendController extends ModuleEngine
{
    /**
     * @var ArticleRepository
     */
    private $articles;

    /**
     * @var ArticleCategoryRepository
     */
    private $categories;

    /**
     * BackendController constructor.
     *
     * @param ArticleRepository $repository
     */
    public function __construct(ArticleRepository $repository, ArticleCategoryRepository $categories)
    {
        $this->articles = $repository;

        $this->categories = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return $this->make('index')->with('articles', $this->articles->allDescendingOrder());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Article);
    }

    /**
     * Generate a form for editing or creating a model.
     *
     * @param Article $article model to be used.
     * @return \Illuminate\Contracts\View\View
     */
    public function form(Article $article)
    {
        return $this->make('form')->with('categories', $this->categories->all())->with('article', $article);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Article $article
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // use the global save function.
        $article = $this->save($request, new Article);

        event(new ArticleCreated($article));

        // redirect back to articles index.
        return redirect()->route('admin.articles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($slug)
    {
        return $this->form($this->articles->whereSlug($slug));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $slug)
    {
        $article = $this->articles->whereSlug($slug);

        $this->save($request, $article);

        event(new ArticleUpdated($article));

        return redirect()->route('admin.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($slug)
    {
        $article = $this->articles->whereSlug($slug);

        $article->delete();

        event(new ArticleDeleted($article));

        return response()->json(['status' => 'true', 'redirect' => route('admin.articles.index')]);
    }

    /**
     * Save the data for the menu to the database.
     *
     * @param Request $request
     * @param Article $article
     * @return Article
     * @internal param Article $menu
     */
    public function save(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:3',
            'status' => 'required|integer',
            'category_id' => 'required|integer|exists:article_categories,id',
            'publish_date' => 'required|date',
            'unpublish_date' => 'sometimes|nullable|date|after:publish_date',
        ]);

        // set attribute for the model.
        $article->setAttribute('title', $request['title']);
        $article->setAttribute('content', $request['content']);
        $article->setAttribute('category_id', $request['category_id']);
        $article->setAttribute('status', $request['status']);
        $article->setAttribute('featured_img', str_slug($request['image']));

        // 09/05/2018 $publish_date without time.
        $publish_date = $request['publish_date'] ? Carbon::parse($request['publish_date']) : null;
        $unpublish_date = $request['unpublish_date'] ? Carbon::parse($request['publish_date']) : null;

        // Store the carbon dates to the database.
        $article->setAttribute('publish_date', $publish_date);
        $article->setAttribute('unpublish_date', $unpublish_date);

        // save the article as an audit.
        $article->save();

        return $article;
    }
}

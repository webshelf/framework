<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 20:30.
 */

namespace App\Plugins\Articles;

use App\Classes\Repositories\ArticleCategoryRepository;
use App\Classes\Repositories\ArticleRepository;
use App\Model\Article;
use App\Model\ArticleCategory;
use Illuminate\Http\Request;
use App\Plugins\PluginEngine;
use Illuminate\Validation\Rule;

/**
 * Class Controller.
 */
class BackendController extends PluginEngine
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
        return $this->make('index')->with('articles', $this->articles->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return $this->make('create')->with('categories', $this->categories->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Article $article
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Article $article, Request $request)
    {
        // use the global save function.
        $this->save($request, $article);

        // redirect back to articles index.
        return redirect()->route('admin.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\View
     * @internal param int $id
     */
    public function edit($slug)
    {
        $article = $this->articles->whereSlug($slug);

        return $this->make('edit')->with(['categories' => $this->categories->all(), 'article' => $article]);
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

        return redirect()->route('admin.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $article = $this->articles->whereSlug($slug);

        $article->delete();

        return redirect()->route('admin.articles.index');
    }

    /**
     * Category Index.
     * @param ArticleCategoryRepository $categoryRepository
     * @return \Illuminate\Contracts\View\View
     */
    public function categories(ArticleCategoryRepository $categoryRepository)
    {
        return $this->make('categories')->with('categories', $categoryRepository->all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function categories_store(Request $request)
    {
        $this->validate($request,['unique:title']);

        $category = new ArticleCategory;
        $category->title = $request['name'];
        $category->auditSave();

        return redirect()->route('admin.articles.categories.index');
    }

    /**
     * @param int $id
     * @param ArticleCategoryRepository $categoryRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function categories_destroy(int $id, ArticleCategoryRepository $categoryRepository)
    {
        $categoryRepository->whereID($id)->delete();

        return redirect()->route('admin.articles.categories.index');
    }

    /**
     * Save the data for the menu to the database.
     *
     * @param Request $request
     * @param Article $article
     * @return bool
     * @internal param Article $menu
     */
    public function save(Request $request, Article $article)
    {
        $this->validate($request, ['title' => ['min:3|max:255', Rule::unique('articles')->ignore($article->id)], 'content' => ['min:3']]);

        // set attribute for the model.
        $article->setAttribute('title', $request['title']);
        $article->setAttribute('content', $request['content']);
        $article->setAttribute('category_id', $request['category']);
        $article->setAttribute('status', $request['status']);
        $article->setAttribute('featured_img', $request['image']);

        return $article->auditSave();
    }
}

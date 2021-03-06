<?php

namespace App\Modules\Articles;

use App\Model\Categories;
use Illuminate\Http\Request;
use App\Modules\ModuleEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CategoryController.
 */
class CategoryController extends ModuleEngine
{
    use RefreshDatabase;

    /**
     * Category Index.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->make('categories')->with('categories', Categories::all());
    }

    /**
     * Store a new category created by the form.
     *
     * @param Request $request
     * @param Categories $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Categories $category)
    {
        $this->validate($request, ['unique:title']);

        $category->fill([
            'title' => $request->get('title'),
            'slug'  => str_slug($request->get('title')),
        ])->save();

        return redirect()->route('admin.articles.categories.index');
    }

    /**
     * Destroy or delete an exiting category.
     *
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(string $slug)
    {
        $category = Categories::firstWhereSlug($slug);

        if (count($category->articles) == 0) {
            $category->delete();
        }

        return response()->json(['status' => 'true', 'redirect' => route('admin.articles.categories.index')]);
    }
}

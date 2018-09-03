<?php

namespace Tests\Article;

use App\Model\Categories;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ArticleCategoryBackendTest
 *
 * @package Tests\Article
 */
class ArticleCategoryBackendTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function a_category_listing_index_is_shown()
    {
        $this->signIn();

        $category = factory('App\Model\Categories')->create();

        $response = $this->visit('admin/articles/categories');

        $response->assertSee($category->title);
    }

    /**
     * @test
     * @var Categories $category
     */
    public function a_category_can_be_created_and_stored()
    {
        $this->signIn();

        $this->post('admin/articles/categories', ['title' => 'foo']);

        $this->assertDatabaseHas('article_categories', ['title' => 'foo', 'slug' => 'foo']);
    }

    /**
     * @test
     */
    public function an_exiting_category_can_be_deleted()
    {
        $this->signIn();

        $category = factory('App\Model\Categories')->create();

        $this->delete("admin/articles/categories/{$category->slug}");

        $this->assertDatabaseHas('article_categories', ['title' => $category->title, 'deleted_at' => now()]);
    }
}

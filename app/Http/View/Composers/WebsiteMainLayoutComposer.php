<?php

namespace App\Http\View\Composers;

use App\Category;
use App\Models\Post;
use Illuminate\View\View;

class WebsiteMainLayoutComposer
{
	/**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $categories = Category::with('subCategories')->get();
        $latest_posts = Post::latest()->limit(3)->get();
        
        $view->with('categories', $categories);
        $view->with('latest_posts', $latest_posts);
    }
}
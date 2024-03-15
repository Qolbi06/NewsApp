<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function Index(){
        $title = 'Home';
        
        $category = Category::latest()->get();

        $categoryNews = News::with('category')->latest()->get();
        
        return view('frontend.news.index', compact(
            'title',
            'category',
            'categoryNews'
        ));
    }
}
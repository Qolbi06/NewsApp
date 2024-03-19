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

        $sliderNews = News::latest()->limit(3)->get();
        
        return view('frontend.news.index', compact(
            'title',
            'category',
            'sliderNews',
        ));
    }

    public function detailNews($slug){
        $category = Category::latest()->get();
        
        $news = News::where('slug', $slug)->first();

        return view('frontend.news.detail', compact(
            'category',
            'news'
        ));
    }

    public function detailCategory($slug){
        $category = Category::latest()->get();
        
        $detailCategory = Category::where('slug', $slug)->first();

        $news = News::where('category_id', $detailCategory->id)->latest()->get();

        return view('frontend.news.detail-category', compact(
            'category',
            'detailCategory',
            'news'
        ));
    }
}
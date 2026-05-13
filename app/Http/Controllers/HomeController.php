<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')
            ->where('sale_price', '<>', '')
            ->inRandomOrder()
            ->take(8)
            ->get();

        $fproducts = Product::where('featured', 1)->get()->take(8);
        return view('index', compact('slides', 'categories', 'sproducts', 'fproducts'));
    }
}

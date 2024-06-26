<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function products()
    {
        return view('products');
    }

    public function singleProduct()
    {
        return view('single-product');
    }

    public function contact()
    {
        return view('contact');
    }
}
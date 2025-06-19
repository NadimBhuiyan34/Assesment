<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        $products = Product::where('status', 1)->with('images')->get();


        return Inertia::render('Home', ['products' => $products]);
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'category', 'brand', 'review.user'])
            ->where('slug', $slug)
            ->firstOrFail();
        $reviews = $product->review;
        return Inertia::render('client_pages/ProductDetails', [
            'product' => $product,
            'reviews' => $reviews
        ]);
    }
    
}

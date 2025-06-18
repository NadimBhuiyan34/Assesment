<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($request->input('product_id'));

        $path = $request->file('image')->store('products', 'public');

        if ($request->boolean('is_featured')) {
            $product->images()->update(['is_featured' => false]);
        }

        $product->images()->create([
            'image_path' => $path,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return back()->with('success', 'Image uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductImageRequest $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        $productImage->delete();

        return back()->with('success', 'Image uploaded successfully.');
    }
}

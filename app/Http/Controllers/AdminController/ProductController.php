<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::select('id', 'name', 'slug', 'stock', 'status')
            ->when(
                $search,
                fn($query) =>
                $query->where('name', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate(2)
            ->withQueryString();

        return Inertia::render('admin/product/Index', [
            'products' => $products,
            'filters' => compact('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'slug', 'name')->where('status', 1)->get();

        return Inertia::render('admin/product/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {


        // 1. Validate incoming data
        $data = $request->validated();

        // 2. Create the product
        $product = Product::create([
            'name'            => $data['name'],
            'slug'            => $data['slug'],
            'description'     => $data['description'],
            'price'           => $data['price'],
            'discount_price'  => $data['discount_price'],
            'stock'           => $data['stock'],
            'is_featured'     => $data['is_featured'],
            'is_active'       => $data['is_active'],
            'weight'          => $data['weight'],
            'length'          => $data['length'],
            'width'           => $data['width'],
            'height'          => $data['height'],
            'brand_id'        => $data['brand_id'] ?? null,
            'shop_id'         => $data['shop_id'] ?? null,
            'tags'            => $data['tags'],
            'specifications'  => $data['specifications'],
            'status'          => $data['status'],
        ]);

        // 3. Sync categories (many-to-many pivot)
        $product->categories()->sync($data['productCategories']);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'slug', 'name')->where('status', 1)->get();

        // Eager load the categories and convert product to array with category IDs
        $product->load('categories');

        return Inertia::render('admin/product/Edit', [
            'product' => [
                ...$product->toArray(),
                'categories' => $product->categories->pluck('id'), // <-- Convert to array of IDs
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // 2. Update the product
        $product->update([
            'name'            => $data['name'],
            'description'     => $data['description'],
            'price'           => $data['price'],
            'discount_price'  => $data['discount_price'],
            'stock'           => $data['stock'],
            'is_featured'     => $data['is_featured'],
            'is_active'       => $data['is_active'],
            'weight'          => $data['weight'],
            'length'          => $data['length'],
            'width'           => $data['width'],
            'height'          => $data['height'],
            'brand_id'        => $data['brand_id'] ?? null,
            'shop_id'         => $data['shop_id'] ?? null,
            'tags'            => $data['tags'],
            'specifications'  => $data['specifications'],
            'status'          => $data['status'],
        ]);

        // 3. Sync the pivot table for categories
        $product->categories()->sync($data['productCategories']);

        // 4. Redirect back
        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

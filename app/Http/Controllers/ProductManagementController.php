<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('laravel-examples.Product_management.Product_management', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->route('product-management')->with('success', 'Product saved successfully!');
    }

    public function create()
    {
        return view('laravel-examples.Product_management.Product_create');
    }

    public function edit(Product $product)
    {
        return view('laravel-examples.Product_management.Product_create', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product-management')->with('success', 'Product deleted successfully!');
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->route('product-management')->with('success', 'Product updated successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(ProductRequest $request)
    {
        $this->productService->storeProduct($request->validated());

        return redirect()->route('products.index')
               ->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->productService->updateProduct($product->id, $request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product->id);

        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully');
    }
    public function search(Request $request)
    {
        $products = $this
            ->productService
            ->searchProduct($request->input('search'))
            ->get();

        return view('product.index', compact('products'));
    }
}

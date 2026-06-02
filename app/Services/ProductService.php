<?php
namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        return Product::paginate(7);
    }

    public function storeProduct($data)
    {
        Product::create($data);
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function updateProduct($id, $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
    public function searchProduct($searchTerm)
    {
        $products = Product::where('name', 'like', "%{$searchTerm}%");
        return $products;
    }
}

<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getAllOrders()
    {
        return Order::with('customer')->get();
    }
    public function getAllCustomers()
    {
        return Customer::all();
    }
    public function getAllProducts()
    {
        return Product::where('stock_quantity', '>', 0)
                    ->orderBy('name')
                    ->get();
    }

    public function createOrder(array $data)
    {
        DB::beginTransaction();

        $order = Order::create([
            'customer_id' => $data['customer_id'],
            'total_amount' => $data['total_amount'],
            'status' => 'Completed'
        ]);

        foreach ($data['items'] as $item) {

            $product = Product::find($item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price']
            ]);

            $product->stock_quantity = abs($product->stock_quantity - $item['quantity']);
            $product->save();
        }

        DB::commit();
        return $order;
    }
    public function getOrderDetails($orderId)
    {
       $order= Order::with('customer','orderItems.product')->findOrFail($orderId);
       return $order;
    }
    public function deleteOrder($orderId)
        {
            $order = Order::findOrFail($orderId);
            $order->delete();
        }
}


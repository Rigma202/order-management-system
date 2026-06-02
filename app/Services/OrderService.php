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
        return Order::with('customer')->paginate(7);
    }
    public function getAllCustomers()
    {
        return Customer::all();
    }
    public function getAllProducts()
    {
        return Product::all();
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

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price']
            ]);
            Product::where('id', $item['product_id'])
                ->decrement('stock_quantity', $item['quantity']);
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


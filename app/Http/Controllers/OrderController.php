<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Session\Store;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('orders.index', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = $this->orderService->getAllCustomers();
        $products = $this->orderService->getAllProducts();
        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $this->orderService->createOrder($data);
        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

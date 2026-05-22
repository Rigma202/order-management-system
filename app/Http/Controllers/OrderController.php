<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Session\Store;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;

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
        $order = $this->orderService->createOrder($data);
        Mail::to($order->customer->email)
            ->queue(new OrderPlacedMail($order));
        return redirect()->route('orders.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order_details = $this->orderService->getOrderDetails($order->id);
        return view('orders.show', compact('order_details'));
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
        $this->orderService->deleteOrder($order->id);
        return redirect()->route('orders.index');
    }
}

@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow p-4" style="width: 600px;">

        <h2 class="text-center mb-4">Edit Order</h2>

        <form id="orderForm">

            @csrf

            <input type="hidden" id="order_id" value="{{ $order->id }}">

            <!-- CUSTOMER -->
            <div class="mb-3">
                <label class="form-label">Customer</label>

                <select id="customer_id" class="form-control form-control-sm">
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>

                <small class="text-danger" id="customer_error"></small>
            </div>

            <!-- STATUS -->
            <div class="mb-3">
                <label class="form-label">Status</label>

                <select id="status" class="form-control form-control-sm">
                    <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>

                <small class="text-danger" id="status_error"></small>
            </div>

            <hr>

            <h5>Order Items</h5>

            <table class="table table-bordered" id="itemsTable">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <select class="form-control product">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="number" class="form-control qty"
                                       value="{{ $item->quantity }}">
                            </td>

                            <td>
                                ₹ {{ number_format($item->product->price, 2) }}
                            </td>

                            <td>
                                ₹ {{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- TOTAL -->
            <div class="text-end mb-3">
                <h5>
                    Total: ₹ {{ number_format($order->total_amount, 2) }}
                </h5>
            </div>

            <!-- BUTTONS -->
            <div class="text-center">

                <a href="{{ route('orders.index') }}" class="btn btn-danger btn-sm px-4">
                    Cancel
                </a>

                <button class="btn btn-success btn-sm px-4">
                    Update Order
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

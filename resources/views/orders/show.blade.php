@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow p-4" style="width: 650px;">

        <h2 class="text-center mb-4"> Order Details</h2>

        <form id="orderForm">

            @csrf

            <!-- CUSTOMER -->
            <div class="mb-3">
                <label class="form-label">Customer : {{ $order_details->customer->name }}</label>
            </div>

            <hr>

            <table class="table table-bordered" id="itemsTable">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th width="120">Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                @foreach($order_details->orderItems as $item)
                <tbody id="orderItems">

                    <tr class="order-row">
                        <td>
                            {{ $item->product->name }}
                        </td>

                        <td>
                            <input type="number" class="form-control qty" value="{{ $item->quantity }}" min="1" disabled>
                        </td>

                        <td class="price">₹ {{$item->subtotal}}</td>
                    </tr>

                </tbody>
                @endforeach
            </table>

            <!-- TOTAL -->
            <div class="text-end mb-3">
                <h5>Total: ₹ <span>{{ $order_details->total_amount  }}</span></h5>
            </div>

            <!-- BUTTONS -->
            <div class="text-center">

                <a href="{{ route('orders.index') }}" class="btn btn-success btn-sm px-4">
                    Back
                </a>
            </div>

        </form>

    </div>

</div>

@endsection

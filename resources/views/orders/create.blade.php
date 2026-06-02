@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow p-4" style="width: 650px;">

        <h2 class="text-center mb-4">Create Order</h2>

        <form id="orderForm">

            @csrf

            <!-- CUSTOMER -->
            <div class="mb-3">
                <label class="form-label">Customer</label>

                <select id="customer_id" class="form-control form-control-sm">
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>

                <small class="text-danger" id="customer_error"></small>
            </div>

            <hr>

            <!-- PRODUCTS -->
            <h5>Products</h5>
            <small class="text-danger" id="items_error"></small>
            <table class="table table-bordered" id="itemsTable">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Available Stock</th>
                        <th width="120">Qty</th>
                        <th>Price</th>
                        <th>
                            <button type="button" class="btn btn-sm btn-primary" id="addRow">
                                + Add Product
                            </button>
                        </th>
                    </tr>
                </thead>

                <tbody id="orderItems">

                <tr class="order-row">
                    <td>
                        <select class="form-control product">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><label class="form-control stock_quantity">0</label></td>
                    <td>
                        <input type="number" class="form-control qty" value="1" min="1">
                    </td>

                    <td class="price">₹ 0.00</td>

                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                    </td>
                </tr>

                </tbody>

            </table>

            <!-- TOTAL -->
            <div class="text-end mb-3">
                <h5>Total: ₹ <span id="totalAmount">0.00</span></h5>
            </div>

            <!-- BUTTONS -->
            <div class="text-center">

                <a href="{{ route('orders.index') }}" class="btn btn-danger btn-sm px-4">
                    Cancel
                </a>

                <button type="submit" class="btn btn-success btn-sm px-4">
                    Place Order
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
@push('scripts')
<script src="{{ asset('js/order.js') }}"></script>
@endpush

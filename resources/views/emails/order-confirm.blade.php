<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>

    <h2>Order Placed Successfully</h2>

    <p>Order ID: {{ $order->id }}</p>

    <p>Customer: {{ $order->customer->name }}</p>

    <p>Total Amount: ₹{{ $order->total_amount }}</p>

    <p>Status: {{ $order->status }}</p>

    <h3>Products:</h3>

    <ul>
        @foreach($order->orderItems as $item)

            <li>
                {{ $item->product->name }}
                -
                Quantity: {{ $item->quantity }}
            </li>

        @endforeach
    </ul>

</body>
</html>

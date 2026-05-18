@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h2>Orders</h2>

    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        Create New Order
    </a>

</div>

<table class="table table-bordered">

    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Total Amount</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($orders as $order)

    <tr>

        <td>#{{ $order->id }}</td>

        <td>{{ $order->customer->name }}</td>

        <td>₹ {{ number_format($order->total_amount, 2) }}</td>

        <td>
            @if($order->status == 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
            @else
                <span class="badge bg-success">Completed</span>
            @endif
        </td>

        <td>

            <a href="{{ route('orders.show', $order->id) }}"
               class="btn btn-info btn-sm">
                View
            </a>

            <form action="{{ route('orders.destroy', $order->id) }}"
                  method="POST"
                  class="delete-form"
                  style="display:inline;">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    Delete order
                </button>

            </form>

        </td>

    </tr>

    @endforeach

</table>

@endsection


@push('scripts')
<script>
$(document).on('submit', '.delete-form', function(e){
    e.preventDefault();

    let form = this;

    Swal.fire({
        title: "Are you sure?",
        text: "This order will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {

        if (result.isConfirmed) {
            form.submit();
        }

    });

});
</script>
@endpush

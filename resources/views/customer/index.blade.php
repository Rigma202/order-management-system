@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h2>Customers</h2>

    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        Add Customer
    </a>

</div>

<table class="table table-bordered">

    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>

    @foreach($customers as $customer)

    <tr>

        <td>{{ $customer->name }}</td>
        <td>{{ $customer->email }}</td>
        <td>{{ $customer->phone_number }}</td>

        <td>

            <a href="{{ route('customers.edit',$customer->id) }}"
               class="btn btn-warning btn-sm">
                Edit
            </a>

            <form action="{{ route('customers.destroy',$customer->id) }}"
                  method="POST"
                  class="delete-form"
                  style="display:inline;">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    Delete
                </button>

            </form>

        </td>

    </tr>

    @endforeach

</table>
<div class="mt-3">
    {{ $customers->links() }}
</div>

@endsection
@push('scripts')
<script>
$(document).on('submit', '.delete-form', function(e){
    e.preventDefault();
    let form = this;
    Swal.fire({
        title: "Are you sure?",
        text: "This customer will be deleted permanently!",
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

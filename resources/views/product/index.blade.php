@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h2>Products</h2>
    <input
        type="text"
        name="search"
        placeholder="Search product..."
        value="{{ request('search') }}"
    >
    <button type="submit" id="search_product" class="btn btn-primary">Search</button>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        Add Product
    </a>

</div>

<table class="table table-bordered">

    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Action</th>
    </tr>

    @foreach($products as $product)

    <tr>

        <td>{{ $product->name }}</td>
        <td>{{ $product->description }}</td>
        <td>₹ {{ number_format($product->price, 2) }}</td>
        <td>{{ $product->stock_quantity }}</td>
        <td>
            <a href="{{ route('products.edit',$product->id) }}"
               class="btn btn-warning btn-sm">
                Edit
            </a>

            <form =  action="{{ route('products.destroy',$product->id) }}"
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


@endsection
@push('scripts')
<script>
$(document).on('submit', '.delete-form', function(e){
    e.preventDefault();
    let form = this;
    Swal.fire({
        title: "Are you sure?",
        text: "This product will be deleted permanently!",
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
$(document).on('click', '#search_product', function(){
    let searchTerm = $('input[name="search"]').val();
    window.location.href = "{{ route('products.search') }}?search=" + searchTerm;
});
</script>
@endpush

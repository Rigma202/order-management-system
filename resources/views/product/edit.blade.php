@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow p-4" style="width: 450px;">

        <h2 class="text-center mb-4">Edit Product</h2>

        <form id="productForm">

            @csrf

            <input type="hidden" id="product_id" value="{{ $product->id }}">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" id="name" value="{{ $product->name }}" class="form-control form-control-sm">
                <small class="text-danger" id="name_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea type="text" id="description" class="form-control form-control-sm">{{ $product->description }}</textarea>
                <small class="text-danger" id="description_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" id="price" value="{{ $product->price }}" class="form-control form-control-sm" step="0.01">

            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" id="stock" value="{{ $product->stock_quantity }}" class="form-control form-control-sm">

            </div>

            <div class="text-center">
                <a href="{{ route('products.index') }}" class="btn btn-danger btn-sm px-4">
                    Cancel
                </a>
                <button class="btn btn-success btn-sm px-4">
                    Update
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
@push('scripts')

<script>

$('#productForm').submit(function(e){

    e.preventDefault();

    let id = $('#product_id').val();

    let name = $('#name').val();
    let description = $('#description').val();
    let price = $('#price').val();
    let stock = $('#stock').val();
    let hasError = false;
    if (!name) {
        $('#name_error').text('Name is required');
        hasError = true;
    }

    if (!description) {
        $('#description_error').text('Description is required');
        hasError = true;
    }

    if (hasError) {
        return;
    }
    $.ajax({
        url: "/products/" + id,
        type: "POST",

        data: {
            _method: 'PUT',
            name: name,
            description: description,
            price: price,
            stock_quantity: stock
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response){

            Swal.fire({
                icon: 'success',
                title: 'Updated',
                text: 'Product updated successfully'
            }).then(() => {
                window.location.href = "/products";
            });

        },

        error: function(xhr){

            $('.text-danger').text('');

            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                if(errors.name){
                    $('#name_error').text(errors.name[0]);
                }
                if(errors.description){
                    $('#description_error').text(errors.description[0]);
                }
            }
        }
    });

});

</script>

@endpush

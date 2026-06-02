@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow p-4" style="width: 450px;">

        <h2 class="text-center mb-4">Add Product</h2>

        <form action="{{ route('products.store') }}" method="POST" id="productForm">

            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" id="product_name" class="form-control form-control-sm">
                <small class="text-danger" id="product_name_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>

                <textarea
                    name="description"
                    id="product_description"
                    class="form-control form-control-sm"
                    rows="4"
                ></textarea>

                <small class="text-danger" id="description_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" id="product_price" min=0 class="form-control form-control-sm" step="0.01">

            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" id="product_stock" min=0 class="form-control form-control-sm">

            </div>


            <div class="text-center">
                <a href="{{ route('products.index') }}" class="btn btn-danger btn-sm px-4">
                    Cancel
                </a>
                <button class="btn btn-success btn-sm px-4">
                    Save
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
@push('scripts')
<script>
$('#productForm').submit(function(e){

    let name=document.getElementById('product_name').value;
    let description=document.getElementById('product_description').value;
    let price=document.getElementById('product_price').value;
    let stock=document.getElementById('product_stock').value;
    console.log(name,description,price,stock);

    e.preventDefault();
    $.ajax({
        url: "/products",
        type: 'POST',
        data: {

            name:name,
            description:description,
            price:price,
            stock_quantity:stock

        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(response){
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text:' New Product added successfully'
            }).then(() => {
            location.href = "/products";
            });

        },
        error: function(xhr){
            if(xhr.status === 422){

                let errors = xhr.responseJSON.errors;
                if(errors.name){
                    $('#product_name_error').text(errors.name[0]);
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

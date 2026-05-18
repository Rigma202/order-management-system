@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow p-4" style="width: 450px;">

        <h2 class="text-center mb-4">Edit Customer</h2>

        <form id="customerForm">

            @csrf

            <input type="hidden" id="customer_id" value="{{ $customer->id }}">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" id="name" value="{{ $customer->name }}" class="form-control form-control-sm">
                <small class="text-danger" id="name_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" id="email" value="{{ $customer->email }}" class="form-control form-control-sm">
                <small class="text-danger" id="email_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" id="phone_number" value="{{ $customer->phone_number }}" class="form-control form-control-sm">
                <small class="text-danger" id="phone_number_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea id="address" rows="3" class="form-control form-control-sm">{{ $customer->address }}</textarea>
                <small class="text-danger" id="address_error"></small>
            </div>

            <div class="text-center">
                <a href="{{ route('customers.index') }}" class="btn btn-danger btn-sm px-4">
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

$('#customerForm').submit(function(e){

    e.preventDefault();

    let id = $('#customer_id').val();
    let name = $('#name').val();
    let email = $('#email').val();
    let phone_number = $('#phone_number').val();
    let address = $('#address').val();
    let hasError = false;
    if (!name) {
        $('#name_error').text('Name is required');
        hasError = true;
    }

    if (!email) {
        $('#email_error').text('Email is required');
        hasError = true;
    }

    if (!phone_number) {
        $('#phone_number_error').text('Phone number is required');
        hasError = true;
    }

    if (!address) {
        $('#address_error').text('Address is required');
        hasError = true;
    }
    if (hasError) {
            return;
        }
    $.ajax({
        url: "/customers/" + id,
        type: "POST",

        data: {
            _method: 'PUT',
            name: name,
            email: email,
            phone_number: phone_number,
            address: address
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response){

            Swal.fire({
                icon: 'success',
                title: 'Updated',
                text: 'Customer updated successfully'
            }).then(() => {
                window.location.href = "/customers";
            });

        },

        error: function(xhr){

            $('.text-danger').text('');

            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                if(errors.name){
                    $('#name_error').text(errors.name[0]);
                }
                if(errors.email){
                    $('#email_error').text(errors.email[0]);
                }
                if(errors.phone_number){
                    $('#phone_number_error').text(errors.phone_number[0]);
                }
                if(errors.address){
                    $('#address_error').text(errors.address[0]);
                }
            }
        }
    });

});

</script>

@endpush

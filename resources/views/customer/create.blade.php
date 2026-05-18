@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">

    <div class="card shadow p-4" style="width: 450px;">

        <h2 class="text-center mb-4">Add Customer</h2>

        <form action="{{ route('customers.store') }}" method="POST" id="customerForm">

            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm">
<small class="text-danger" id="name_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-sm">
                <small class="text-danger" id="email_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control form-control-sm">
                <small class="text-danger" id="phone_number_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" id="address" rows="3" class="form-control form-control-sm"></textarea>
                <small class="text-danger" id="address_error"></small>
            </div>

            <div class="text-center">
                <a href="{{ route('customers.index') }}" class="btn btn-danger btn-sm px-4">
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
$('#customerForm').submit(function(e){

    let name=document.getElementById('name').value;
    let email=document.getElementById('email').value;
    let phone_number=document.getElementById('phone_number').value;
    let address=document.getElementById('address').value;
    console.log(name,email,phone_number,address);

    e.preventDefault();
    $.ajax({
        url: "/customers",
        type: 'POST',
        data: {

            name:name,
            email:email,
            phone_number:phone_number,
            address:address

        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(response){
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text:'Customer added successfully'
            }).then(() => {
            location.href = "/customers";
            });

        },
        error: function(xhr){
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

@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard</h2>

<div class="row">

    <div class="col-md-4">
        <div class="card p-3">
            <h4>Total Customers - {{ $customerCount }}</h4>

        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h4>Total Products - {{ $productCount }}</h4>

        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h4>Total Orders - {{ $orderCount }}</h4>

        </div>
    </div>

</div>

@endsection

@extends('CorpHRM.layout.master')

@section('title')
<title> CorpHRM Dashboard</title>
@endsection

@section('content')



<div class="row">
    <div class="col-md-12 col-xl-4">
        <div class="card bg-c-yellow order-card">
            <div class="card-body">
                <h6 class="text-white">Employee Management</h6>
                <h2 class="text-white">12,562</h2>
                {{-- <p class="m-b-0">$5,032 <i class="feather icon-arrow-up m-l-10"></i></p> --}}
                <i class="card-icon feather icon-filter"></i>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card bg-c-blue order-card">
            <div class="card-body">
                <h6 class="text-white">Recuirement</h6>
                <h2 class="text-white">2,562</h2>
                {{-- <p class="m-b-0">$5,032 <i class="feather icon-arrow-up m-l-10"></i></p> --}}
                <i class="card-icon feather icon-user"></i>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card bg-c-red order-card">
            <div class="card-body">
                <h6 class="text-white">Claims</h6>
                <h2 class="text-white">562</h2>
                {{-- <p class="m-b-0">$5,032 <i class="feather icon-arrow-up m-l-10"></i></p> --}}
                <i class="card-icon feather icon-pocket"></i>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card bg-c-green order-card">
            <div class="card-body">
                <h6 class="text-white">Loans</h6>
                <h2 class="text-white">62</h2>
                {{-- <p class="m-b-0">$5,032 <i class="feather icon-arrow-up m-l-10"></i></p> --}}
                <i class="card-icon feather icon-user-minus"></i>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card bg-c-yellow order-card">
            <div class="card-body">
                <h6 class="text-white">Trainings</h6>
                <h2 class="text-white">152</h2>
                {{-- <p class="m-b-0">$5,032 <i class="feather icon-arrow-up m-l-10"></i></p> --}}
                <i class="card-icon feather icon-shield"></i>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card bg-c-yellow order-card">
            <div class="card-body">
                <h6 class="text-white">Paye</h6>
                <h2 class="text-white">2</h2>
                {{-- <p class="m-b-0">$5,032 <i class="feather icon-arrow-up m-l-10"></i></p> --}}
                <i class="card-icon feather  icon-bar-chart-2"></i>
            </div>
        </div>
    </div>
    

</div>

@endsection
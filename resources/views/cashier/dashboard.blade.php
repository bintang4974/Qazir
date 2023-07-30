@extends('layouts.master')
@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid ">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body text-center">
                    <h1>Welcome!</h1>
                    <h2>You are logged in as a cashier</h2>
                    <hr>
                    <a href="{{ route('transaction.new') }}" class="btn btn-primary">New Transaction</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app.noside')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">


    <div class="card card-body border-0 shadow table-wrapper table-responsive align-items-center">
        <h1>Wilkomen</h1>
        <br>
        <a href="{{url('dashboard')}}" type="button" class="btn btn-sm btn-outline-gray-600">zur Dashboard</a>
        <br>
        <a href="{{url('register')}}" type="button" class="btn btn-sm btn-outline-gray-600">zur Register</a>
        <br>
        <a href="{{url('login')}}" type="button" class="btn btn-sm btn-outline-gray-600">zur Login</a>
    </div>
    <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">

    </div>
    </div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">

                    @if(Auth::user()->checkAdmin())
                        <div class="col-sm-4">
                        <a href="./management/category">
                        <img src="{{asset('image/management.png')}}" height="100" width="100">
                        Management</a>
                        </div>

                        @endif
                        <div class="col-sm-4">
                        <a href="./cashier">
                        <img src="{{asset('image/cash.png')}}" height="100" width="100">
                        
                        Cashier</a>
                        </div>

                          @if(Auth::user()->checkAdmin())
                        <div class="col-sm-4">
                        <a href="./report">  <img src="{{asset('image/report.png')}}" height="100" width="100">
                        Report</a>
                        </div>
                        @endif
                    </div>
 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

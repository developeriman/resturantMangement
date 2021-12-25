@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-2">
      @include('sidebar')
        
        </div>

        <div class="col-10">
    <div class="card">
        <div class="card-header">
        <h6>Create Table</h6>
        <a href="./management/tab_userle/create" class='btn btn-primary float-right'>Create Table</a>
        </div>
        <div class="card-body">
        @if (session('status'))
    <div class="alert alert-success alert-dismissible" >
    <button type="button" class="close" data-dismiss="alert">&times;</button>

        {{ session('status') }}
    </div>
@endif
 

<table class="table">
    <thead>
        <tr>
            <td>id</td>
            <td>Name</td>
            <td>Role</td>
            <td>Email</td>
            <!-- <td>Edit</td>
            <td>Delete</td> -->
        </tr>
    </thead>
    <tbody>
 
    @foreach($User as $tab_user)
    <tr>
        <td> {{$tab_user->id }}</td>
        <td> {{$tab_user->name }}</td>
        <td> {{$tab_user->role }}</td>
        <td> {{$tab_user->email }}</td>
       
    </tr> 
    @endforeach
   
    </tbody>

</table>



        </div>

        <div class="card-footer">
        
        </div>
    </div>


        </div>
    </div>

</div>
@endsection
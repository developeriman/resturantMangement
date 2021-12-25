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
        <a href="./management/table/create" class='btn btn-primary float-right'>Create Table</a>
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
            <td>Status</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
 
    @foreach($mod_tabl as $tab)
    <tr>
        <td> {{$tab->id }}</td>
        <td> {{$tab->name }}</td>
        <td> {{$tab->status }}</td>
        <td><a href="./management/table/{{$tab->id }}/edit" class='btn btn-warning'>Edit</a></td>
        
        <td><form action="./management/table/{{$tab->id }}" method='POST'>
        @csrf
        @method('DELETE')
        <input type="submit"  class='btn btn-danger' value='Delete'>
        </form></td>
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
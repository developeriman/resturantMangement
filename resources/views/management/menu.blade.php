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
        <h6>Create Menu</h6>
        <a href="./management/menu/create" class='btn btn-primary float-right'>Create Menu</a>
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
            <td>Price</td>
            <td>Image</td>
            <td>Description</td> 
            <td>Category</td> 
            <td>Edit</td>
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
    @foreach($menus as $m)
    <tr>
            <td>{{$m->id}}</td>
            <td>{{$m->name}}</td>
            <td>{{$m->price}}</td>
          
            <td>  <img src="{{asset('uploaded_img')}}/{{$m->image}}" height='100' width='100' alt=""></td>
            <td>{{$m->description}}</td> 
            <td>{{$m->getCat[0]->name}}</td> 
            
            <td><a href="./management/menu/{{$m->id}}/edit" class='btn btn-warning'>Edit</a></td>
            <td>
                <form action="./management/menu/{{$m->id}}" method='POST'>
                @CSRF
                @method('DELETE')
                    <input type="submit" value='Delete' class='btn btn-danger'>
                </form>
            </td>
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
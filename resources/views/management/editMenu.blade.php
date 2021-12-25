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
        <h6>Edit Menu</h6>
         </div>
        <div class="card-body">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
        {{ $error }}    
        </div>
    
@endforeach



        <form action="./management/menu/{{$menus->id}}" method='POST' enctype='multipart/form-data'>
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class='form-control' value='{{$menus->name}}' name='name'>
        </div>
        <div class="form-group">
            <label for="">Price</label>
            <input type="text" class='form-control' value='{{$menus->price}}' name='price'>
        </div>

        <div class="form-group">
            <label for="">Image</label>
            <input type="file" class='form-control'   name='image'>
        </div>

        <div class="form-group">
            <label for="">Description</label>
            <input type="text" class='form-control'value='{{$menus->description}}'  name='description'>
        </div>

        <div class="form-group">
            <label for="">Add in Category</label>
          
            <select name='cat_id' class='form-control'>
            @foreach($categories as $c)
                <option value="{{$c->id}}" {{($c->id === $menus->cat_id) ? 'selected' : "" }}>{{$c->name}}</option>
            @endforeach
            </select>
        </div>



            <input type="submit" class='btn btn-danger'>
        </form>
        </div>

        <div class="card-footer">
        
        </div>
    </div>


        </div>
    </div>

</div>
@endsection
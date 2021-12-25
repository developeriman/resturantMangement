@extends('layouts.app')

@section('content')

 



<div class="container">

<ul class = "breadcrumb">
              
               <li class = "breadcrumb-item"><a href = "./management">Home</a></li>
               <li class = "breadcrumb-item"><a href="./report">Report</a></li>
               <li class = "breadcrumb-item active"><a href="./report/show">Show Report</a></li>
            </ul>
 


    <div class="row">
       

        <div class="col-12">
    <div class="card">
        <div class="card-header">
        <h6>Report</h6>
      

         </div>
        <div class="card-body">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
        {{ $error }}    
        </div> 
        @endforeach
        <form action="./report/show" method='get'>
        @csrf
        <div class="row"> 
        <div class="col-12">
            @if($sales->count() >0)
            <div class="alert alert-success">
            Sale On Date between {{$dateStart}} and {{$dateEnd}} is $ {{$totalPrice}}  and Sale Count is {{$sales->total()}}
</div>
            @else
<div class="alert alert-danger">
No Data Found On  Date between {{$dateStart}} and {{$dateEnd}} 
</div>
            @endif   



            <table class="myclass">
                <thead>
                <tr class='bg-primary text-white'>
                    <td>#</td>
                    <td>Receipt Id</td>
                    <td>Date Time</td>
                     <td>Table</td>
                      <td>Staff</td>
                      <td>Total Amount</td>
                </tr>    
                </thead>
            <tbody>
            @php
            $countSale = ($sales->currentPage()-1) * $sales->perPage() +1;
                @endphp
@foreach($sales as $s)
<tr >
    <td>{{$countSale++}}</td>
    <td>{{$s->id}}</td>
    <td>{{$s->updated_at}}</td>
    <td>{{$s->table_name}}</td>
    <td>{{$s->user_name}}</td>
    <td>{{$s->total_price}}</td>
</tr>
 


@endforeach


            
            </tbody>
            </table>


            {{$sales->appends($_GET)->links()}}



            <form action="./report/show/excel" method='get'>
            @csrf
            <input type="hidden" name='dateStart' value='{{$dateStart}}'>
            <input type="hidden" name='dateEnd' value='{{$dateEnd}}'>
                <input type="submit" value='Convert to Excel' class='btn btn-warning'>
            </form>
           
        </div> 
        </div>
      
        <div class="card-footer">
        
        </div>
    </div>


        </div>
    </div>

</div>
 

@endsection
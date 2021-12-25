@extends('layouts.app')

@section('content')

<div class="container text-center">
    <div class="receipt-header">
        <h3>UI Monk's Restaurant </h3>
    </div>
    <div class="receipt-body">
        <table class="mycustonTable">
            <thead>
                <tr>
                    <td>#</td>
                    <td>menu</td>
                    <td>Qty</td>
                    <td>Price</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
          
            @foreach($saleDetails as $sd)

                <tr>
                <td>{{$sd->id}}</td>
                 <td>{{$sd->menu_name}}</td>
                 <td>{{$sd->quantity}}</td>
                 <td>{{$sd->menu_price}}</td>
                 <td>{{$sd->menu_price * $sd->quantity}}</td>
                </tr>
                @endforeach
            </tbody>
        
        </table>

<table class="mycustonTable">
    <tr>
      <td class='td' colspan=2>Total Qty</td>
      <td colspan=2>{{$saleDetails->count()}}</td>
       
    </tr>
    <tr>
    <td class='td' colspan=2>Total Price</td>
      <td colspan=2>{{$sale->total_price}}</td>
    </tr>
    <tr>
    <td class='td' colspan=2>payment type</td>
     <td  colspan=2>{{$sale->payment_type}}</td>
     </tr>
     <tr>
      <td class='td' colspan=2>paid amount</td>
      <td  colspan=2>{{$sale->total_received}}</td>
      </tr>
      <tr>
      <td class='td' colspan='2'>Change</td>
      <td colspan='2'>{{$sale->change}}</td>
      
    </tr>

    <tr class='no-print'>
      <td colspan='2'><a href="./cashier" >Go Back</a></td>
      <td colspan='2'><a href="javascript:void(0)" onClick='window.print();return false;'>Print</a></td>
      
    </tr>
</table>
    </div>
    <div class="receipt-footer"> Thank You!</div>
 

</div>
   
@endsection

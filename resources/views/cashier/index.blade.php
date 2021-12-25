@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cashier</div>

                <div class="card-body">

<div class="row">
<div class="col-6">
<div id="tableDetails" class='row mb-5'> </div>
                 
                 <div class="row">
                    <div class="col-6">
                    <button class="btn btn-primary" id='showTable'>
                    View Tables
                    </button>  
                    </div>
                    <div class="col-6">
                    
                    </div>
                 </div>

                 <div id="showSelectedTable">
                 
                 </div>
                 <div id="showSelectedMenuAndTable">
                 
                 </div>
</div>

<div class="col-6">


<nav class="navbar navbar-expand-sm bg-light">
  <ul class="navbar-nav">
  @foreach($categories as $c)
    <li class="nav-item">
      <a class="nav-link" data-id="{{$c->id}}" href="javascript:void(0)">{{$c->name}}</a>
    </li>
@endforeach    
  </ul>
</nav>
<div class="menu-list row mt-5">

</div>

</div>
</div>
              

                
                </div>
            </div>
        </div>
    </div>
</div>

 
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Payment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h3 id='TotalPayment'></h3>
        <h3 id='showChange' class='mt-3'> </h3>
        <input type="text" class='form-control' id='receivedAmt'>
       
        <div class="form-group">
    <label for="">Payment Type</label>
    <select class="form-control" id="payment_type">
    <option value="-" selected disabled> -</option>    
    <option value="Cash">Cash</option>
        <option value="Credit Card">Credit Card</option>
    </select>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary " id='btn_savePayment'   disabled> Save Payment</button>
      </div>

    </div>
  </div>
</div>


<script type="application/javascript">
    $(document).ready(function(){

        $('#tableDetails').hide();

        $('#showTable').click(function(){
         
            if($('#tableDetails').is(':hidden')){
                    $.get('/cashier/getAlltables',function(data){
                        $('#tableDetails').html(data);
                        $('#tableDetails').slideDown();
                        $('#showTable').text('Close Tables')
                        $('#showTable').removeClass('btn btn-primary').addClass('btn btn-danger')
                    })
            }
            else{
                     $('#tableDetails').slideUp();
                     $('#showTable').text('View Tables')
                     $('#showTable').removeClass('btn btn-danger').addClass('btn btn-primary')
            }



        })




$('.nav-link').click(function(){
    
     cat_id = $(this).data('id'); 
     $.get('cashier/getMenuFromCategory/'+cat_id,function(data){
        $('.menu-list').hide()
        $('.menu-list').html(data);
        $('.menu-list').fadeIn('fast')
     })

})
var SELECTED_TABLE_ID = ' ';
var SELECTED_TABLE_NAME = ' ';
var SALES_ID = '';

$('#tableDetails').on('click','.btn-Selected-table',function(){
             SELECTED_TABLE_ID= $(this).data('id');
             SELECTED_TABLE_NAME= $(this).data('name');
             $('#showSelectedTable').html("<BR><h3>Table: "+SELECTED_TABLE_NAME+"</h3><hr>")


$.get('/cashier/getSaleDetails/'+SELECTED_TABLE_ID,function(data){
    $("#showSelectedMenuAndTable").html(data);
})

})






$('.menu-list').on('click', '.btn-selected-menu', function(event){
    SELECTED_MENU_ID = '';
if(SELECTED_TABLE_ID == ' '){
    alert('menus cant be selected unless, Table is selected');
}else{
    SELECTED_MENU_ID = $(this).data('id')
    console.log(SELECTED_MENU_ID +" "+   SELECTED_TABLE_ID  +" "+ SELECTED_TABLE_NAME)
    $.ajax({
        type:"POST",
        url: "/cashier/orderFood", 
        data:{
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "menu_id": SELECTED_MENU_ID,
            "table_id":SELECTED_TABLE_ID,
            "table_name":SELECTED_TABLE_NAME,
            "quantity": 1 
        },
        success: function(result){
         $("#showSelectedMenuAndTable").html(result);
        }}
  );

}
 event.stopImmediatePropagation();

})



$('#showSelectedMenuAndTable').on('click','.btnConfirmOrder',function(event){
SALE_ID = $(this).data('id');

 
    $.ajax({
        type:"POST",
        url: "/cashier/confirmOrder", 
        data:{
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "sale_id": SALE_ID 
        },
        success: function(result){
         $("#showSelectedMenuAndTable").html(result);
        } 
        })
        event.stopImmediatePropagation(); 
    })


    
$('#showSelectedMenuAndTable').on('click','.btnDeleteOrder',function(event){
SALE_ID = $(this).data('id');
    $.ajax({
        type:"POST",
        url: "/cashier/deleteOrder", 
        data:{
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "sale_id": SALE_ID 
        },
        success: function(result){
         $("#showSelectedMenuAndTable").html(result);
        } 
        })

        event.stopImmediatePropagation(); 
    })



  
$('#showSelectedMenuAndTable').on('click','.btnpayment',function(){
    SALES_ID = $(this).data('id');
    totalPayment = $(this).attr('data-totalPayment');
     
        $('#TotalPayment').text("Total Payment "+totalPayment);

        $('#receivedAmt').val(" ");
        $('#showChange').text(" ");
    })



$('#receivedAmt').keyup(function(){
  
    totalPayment = $('.btnpayment').attr('data-totalPayment'); 
    receivedAmt = $('#receivedAmt').val();  
    totalPayment=totalPayment.replace(/\,/g,''); // 1125, but a string, so convert it to number
    totalPayment=parseInt(totalPayment,10); 
    Cal_change =  parseInt(receivedAmt) - totalPayment ; 
    
    $('#showChange').text("Change "+Cal_change);
if(Cal_change >= 0){
$('#btn_savePayment').prop('disabled',false);
}else{
    $('#btn_savePayment').prop('disabled',true);   
}


})




$('#btn_savePayment').click(function(e){
   
    receivedAmt  = $('#receivedAmt').val();
    payment_type =   $('#payment_type').val();
     sales_id = SALES_ID 


$.ajax({
        type:"POST",
        url: "/cashier/savePayment", 
        data:{
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "saleid": sales_id,
            "receivedAmt": receivedAmt,
            "payment_type": payment_type 
        },
        success: function(result){
             
         window.location.href = result;
        } 
        })


e.stopImmediatePropagation(); 
})

})





</script>
@endsection

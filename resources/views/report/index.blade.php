@extends('layouts.app')

@section('content')

 



<div class="container">
 
<ul class = "breadcrumb">
              
               <li class = "breadcrumb-item"><a href = "./management">Home</a></li>
               <li class = "breadcrumb-item active"><a href="./report">Report</a></li>
             
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
           
            <div class="col-4">
            <div class="form-group">
                <div class="input-group date" id="date-start" data-target-input="nearest">
                        <input type="text" name='dateStart' class="form-control datetimepicker-input" data-target="#date-start"/>
                        <div class="input-group-append" data-target="#date-start" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
             </div>

            </div>
            <div class="col-4">
            <div class="form-group">
           <div class="input-group date" id="date-end" data-target-input="nearest">
                <input type="text" name='dateEnd' class="form-control datetimepicker-input" data-target="#date-end"/>
                <div class="input-group-append" data-target="#date-end" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>

            
            </div>
            <div class="col-4">
            <input type="submit" value='Get Report' class=' btn btn-success'>
            </div>
          
        </div>
        </form>



      
        <div class="card-footer">
        
        </div>
    </div>


        </div>
    </div>

</div>


<script type="text/javascript">
    $(function () {
        $('#date-start').datetimepicker({
            format:'L'
        });
        $('#date-end').datetimepicker({
            format:'L',
            useCurrent: false
        });
        $("#date-start").on("change.datetimepicker", function (e) {
            $('#date-end').datetimepicker('minDate', e.date);
        });
        $("#date-end").on("change.datetimepicker", function (e) {
            $('#date-start').datetimepicker('maxDate', e.date);
        });
    });
</script>

@endsection
<?php 

namespace App\Http\Controllers\cashier; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tableModel;
use App\categoryModel;
use App\menuModel;
use App\sale;
use App\saleDetail;
use Illuminate\Support\Facades\Auth;

class cashierController extends Controller
{
    //

    public function index(){
        $categories = categoryModel::all();
        return view('cashier.index')->with('categories',$categories);
    }

    public function getTables(){
         $tab_det = tableModel::all();
         $html = " ";
         foreach ($tab_det as $t) { 
            $html .= "<div class='col-2'>";
            $html .= "<button class='btn btn-warning btn-Selected-table' data-id=".$t->id." data-name=".$t->name.">
            <img src='".url('image/chair.svg')."' height='150' width='75 '>";
            if($t->status == 'unavailable'){
                $html .= "<span class='badge badge-danger'>".$t->name."</span>";
            }else{
                $html .= "<span class='badge badge-success'>".$t->name."</span>";
            }

           
            $html .= "</button></div>"; 
          } 
        return $html;
    }
    
    public function getMenuFromCategory($cat_id) {
        
        $menu_d = menuModel::where('cat_id',$cat_id)->get(); 
        $html = " ";
        foreach($menu_d as $m){
            $html .= "<div class='col-4' >";
            $html .= "<a href='javascript:void(0)' >
            <img class='btn-selected-menu' src='uploaded_img/".$m->image."' data-id='".$m->id."' height=150   width=150 >
            <div class='text-center'>
            ".$m->name."</div>
            <div class='text-center'>
            ".number_format($m->price)." Rs</div></a>";
            $html .= "</div>"; 
        }
        return $html; 
    }



    public function orderFood(Request $req){
         $menu_id =  $req->menu_id;
         $table_id  =  $req->table_id;
         $table_name  =  $req->table_name;
         $menu = menuModel::find($menu_id);

        $sale = sale::where('table_id',$table_id)->where('sale_status','unpaid')->first();
        if(!$sale){
            $user = Auth::user(); 
            $sale = new sale;
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();
            $sale_id = $sale->id;

             $table = tableModel::find($table_id);
             $table->status = 'unavailable';
             $table->save();
            // $sale->xxxxxx = $req->xxxxx;
            //  $sale->xxxxxx = $req->xxxxx;
            //  $sale->xxxxxx = $req->xxxxx;
            //  $sale->xxxxxx = $req->xxxxx;
        }else{
            $sale_id =  $sale->id;
        } 
         $saleDetail = new saleDetail;
         $saleDetail->sale_id =  $sale_id;
         $saleDetail->menu_id = $menu->id;
         $saleDetail->menu_name = $menu->name;
         $saleDetail->menu_price = $menu->price;
         $saleDetail->quantity = $req->quantity;
         $saleDetail->save();
         $sale->total_price = $sale->total_price + ($menu->price * $req->quantity); 
         $sale->save();
         $html =  $this->xyz($sale_id);
        return $html;

    }


    public function getSaleDetails($table_id){
    $sale =  sale::where('table_id',$table_id)->where('sale_status','unpaid')->first();
    $html = " ";
        if($sale){ 
            $sale_id= $sale->id;
            $html =  $this->xyz($sale_id);
            
        }else{
            $html = "No Data Found";
        }
        return  $html;
      
}


public function confirmOrder(Request $req){
    $sale_id = $req->sale_id;
    saleDetail::where('sale_id',$sale_id)->update(['status'=>'Confirmed']);
    $html =  $this->xyz($sale_id);
    return $html;
}


public function deleteOrder(Request $req){
         $sale_id = $req->sale_id;
        $salesDet = saleDetail::find($sale_id);
         $st_sale_id= $salesDet->sale_id;
         $menuPrice = ($salesDet->menu_price * $salesDet->quantity);
         $salesDet->delete();

         $sale_tbl = sale::find($st_sale_id);
         $sale_tbl->total_price = $sale_tbl->total_price - $menuPrice;
         $sale_tbl->save();

          $x = saleDetail::where('sale_id',$st_sale_id)->first();
          if($x){
            $html =  $this->xyz($st_sale_id);
          }else{
            $html = "No Data Found";
          }
          return  $html;

    
}

    private function xyz($sale_id){
    
    $saleDetails =  saleDetail::where('sale_id',$sale_id)->get();
    $html = " ";

    $html.= "<table class='table table-responsive' style='  background: #616161;
    color: #fff'>
        <thead>
            <tr> 
                <td>id</td>
                <td>menu</td>
                <td>quantity</td>
                <td>price</td>
                <td>total</td>
                <td>status</td>
            </tr>
        </thead>
        <tbody>";
        $showPaymentButton = true;
    foreach($saleDetails as $sd){ 
        $html.= "<tr>
            <td>".$sd->id."</td>
            <td>".$sd->menu_name."</td>
            <td>".$sd->quantity."</td>
            <td>".$sd->menu_price."</td>
            <td>".$sd->menu_price * $sd->quantity ."</td>"; 

            if($sd->status == 'notConfirmed'){
                $showPaymentButton = false;   
                $html.=  "<td><button data-id='".$sd->id."' class='btn btn-danger btnDeleteOrder'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";
            }else{
                $html.=  "<td><i class='fa fa-check' aria-hidden='true'></i></td>";
            }  
            $html.= "</tr>";
    }
     $html.= "</tbody>
    </table>"; 
$sale_tp = sale::find($sale_id);
    $html .= "<h3>Total Amount: ".$sale_tp->total_price."</h3>";
    if($showPaymentButton){
        $html .= "<button class='btn btn-success btn-block btnpayment' data-toggle='modal' data-target='#myModal' data-totalPayment=".number_format($sale_tp->total_price)." data-id=".$sale_id.">Payment</button>";
    }else{
         $html .= "<button class='btn btn-primary btn-block btnConfirmOrder' data-id=".$sale_id.">Confirm Order</button>";
    }
     return  $html;
}









public function savePayment(Request $req){
    $saleid = $req->saleid;
    $receivedAmt = $req->receivedAmt;
    $payment_type = $req->payment_type;
    $sale = sale::find($saleid);
    $sale->payment_type = $payment_type;
    $sale->sale_status = "paid";
    $sale->total_received = $receivedAmt;
    $sale->change = $sale->total_price - $receivedAmt;
    $sale->save();
     $tabs = tableModel::find($sale->table_id);
     $tabs->status = 'available';
     $tabs->save();
     return './cashier/showReceipt/'.$saleid;
}




public function showReceipt($s_id){
    $sale = sale::find($s_id);
    $saleDetails =  saleDetail::where('sale_id',$s_id)->get();
    return view('cashier.showReceipt')->with('sale',$sale)->with('saleDetails',$saleDetails);

}






}

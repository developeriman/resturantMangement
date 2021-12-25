<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\sale;

class reportController extends Controller
{
    public function index(){
        
        return view('report.index');
    }

    public function show(Request $req){
        
        $req->validate([ 
            'dateStart' => 'required',
            'dateEnd' => 'required'
        ]);

        $dateStart = date("Y-m-d H:i:s", strtotime($req->dateStart.' 00:00:00'));
        $dateEnd = date("Y-m-d H:i:s", strtotime($req->dateEnd.' 23:59:59'));


        $sales = sale::whereBetween('updated_at',[$dateStart, $dateEnd])->where('sale_status','paid');
        
        return view('report.showReport')->with('dateStart',date("m/d/y H:i:s", strtotime($req->dateStart.' 00:00:00')))->with('dateEnd',date("m/d/y H:i:s", strtotime($req->dateEnd.' 23:59:59')))->with('totalPrice', $sales->sum('total_price'))->with('sales',$sales->paginate(5));
    }


    public function export(){
        
        
    }



}


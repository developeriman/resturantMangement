<?php

namespace App\Http\Controllers\management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\tableModel;

class tableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mod_tabl  = tableModel::all();
        return view('management.showTables')->with('mod_tabl',$mod_tabl);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.createNewTable');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
             
            'name' => 'required',
        ]); 
        $mod_tabl  = new tableModel;
        $mod_tabl->name = $request->name;
        $mod_tabl->save(); 
        $request->session()->flash('status', $request->name.' Added!'); 
        return redirect('/management/table');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table__SR = tableModel::find($id);
        return view('management.editTable')->with('table__SR',$table__SR);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
             
            'name' => 'required',
        ]); 
        $mod_tabl  = tableModel::find($id);
        $mod_tabl->name = $request->name;
        $mod_tabl->save(); 
        $request->session()->flash('status', $request->name.' Updated!'); 
        return redirect('/management/table');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = tableModel::find($id);
        $c->delete();
      session()->flash('status',' Table Deleted!');
       

        return redirect('/management/table');
    }
}

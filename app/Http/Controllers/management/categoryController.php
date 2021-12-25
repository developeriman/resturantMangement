<?php

namespace App\Http\Controllers\management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\categoryModel;

class categoryController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = categoryModel::all();

       return view('management.createCategory')->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.createNewCategory');
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
             
            'cat' => 'required',
        ]);

        

        $mod_cat  = new categoryModel;
        $mod_cat->name = $request->cat;
        $mod_cat->save();


        $request->session()->flash('status', $request->cat.' Category Added!');
         

        return redirect('/management/category');
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
        $category__SR = categoryModel::find($id);
        return view('management.editCategory')->with('category__SR',$category__SR);

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
            'cat' => 'required',
        ]);

        

        $mod_cat  = categoryModel::find($id);
        $mod_cat->name = $request->cat;
        $mod_cat->save();


        $request->session()->flash('status', $request->cat.' Category Updated!');
         

        return redirect('/management/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = categoryModel::find($id);
        $c->delete();
      session()->flash('status',' Category Deleted!');
       

        return redirect('/management/category');
    }
}

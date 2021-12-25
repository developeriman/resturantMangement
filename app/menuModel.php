<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\categoryModel;
class menuModel extends Model
{
    //
    public function getCat(){
        return $this->hasmany('App\categoryModel','id','cat_id');
    }
}

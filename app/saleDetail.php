<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\sale;

class saleDetail extends Model
{
    //

    public function sale()
    {
        return $this->belongsTo(sale::class);
    }


}
 
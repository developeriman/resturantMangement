<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\saleDetail;

class sale extends Model
{
    public function saleDetails()
    {
        return $this->hasMany(saleDetails::class);
    }

}
 
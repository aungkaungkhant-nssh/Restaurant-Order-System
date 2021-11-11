<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLists extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function dish(){
        return $this->belongsTo(Dish::class,"dish_id","id");
    }
}

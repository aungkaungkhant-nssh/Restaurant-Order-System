<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function cook(){
        return $this->hasMany(Cook::class,"dish_id","id");
    }
    public function orderLists(){
        return $this->hasMany(OrderLists::class,"dish_id","id");
    }
    public function bills(){
        return $this->hasMany(Bill::class,"dish_id","id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cook extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function dishes(){
        return $this->belongsTo(Dish::class,"dish_id","id");
    }
}

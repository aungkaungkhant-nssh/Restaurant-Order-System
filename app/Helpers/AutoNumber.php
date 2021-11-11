<?php

namespace App\Helpers;

use App\Models\Cook;

class AutoNumber{
    public  static function generate(){
        $number=mt_rand(1000000000000000,9999999999999999);
      $cook_id=Cook::where("cooking_id",$number)->exists();
      if($cook_id){
         return  self::generate();
      }
      return $number;
    }
}
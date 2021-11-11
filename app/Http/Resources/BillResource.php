<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public function __construct($bills, $t)
    // {
    //     // Ensure you call the parent constructor
    //     parent::__construct($bills);
    //     $this->resource = $resource;

    //     $this->sum = $sum;
    // }
    public function toArray($request)
    {
      
        return [
            "dish_name"=>$this->dish->name,
            "price"=>number_format($this->dish->price)."(MMK)",
            "count"=>$this->count,
            
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->cooking_id,
            "dish_name"=>$this->dishes->name,
            "table_number"=>$this->table_number,
            "count"=>$this->count,
            
        ];
    }
}

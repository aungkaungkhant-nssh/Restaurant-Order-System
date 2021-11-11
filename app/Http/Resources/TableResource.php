<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $status="";
        if($this->status==0){
            $status="မအားသေးပါ";
        }
        if($this->status==1){
            $status="အားပြီ";
        }
        if($this->status==2){
            $status="ခနစောင့်ပေးပါ";
        }
        return [
            "table_number"=>$this->number,
            "status"=>$status
        ];
    }
}

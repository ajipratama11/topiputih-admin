<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'id' => $this->id,
            'program_name' => $this ->program_name,
            'company_name' => $this ->company_name,
            'max_price' => $this ->max_price,
            'date_start' => $this ->date_start,
            'date_end' => $this ->date_end,
            'email' => $this ->email,
            'description' => $this ->description,   
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class commentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'post_id'=>$this->post_id,
            'user_id'=>$this->user_id,
            'comment'=>$this->comment,
            'created_at'=>$this->created_at ? $this->created_at->format('d-m-Y') : null,
            'published_at'=>$this->created_at ?$this->created_at->diffForHumans() : null,


        ];
    }
}

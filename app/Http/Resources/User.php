<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'comments' => Comment::collection($this->comments),
            'purchases' => Article::collection($this->purchases),
            'wishlist' => Article::collection($this->wishlist),
        ];
    }
}

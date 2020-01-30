<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Chat extends JsonResource
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
            'message' => $this->name,
            'sender' => $this->sender,
            'receiver' =>  $this->receiver,
            'status' =>  $this->status,
            'notified' =>  $this->notified,
        ];
    }
}

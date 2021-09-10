<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->loadMissing(['participants','messages']);
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'created_at'=>$this->created_at,
            'participants'=>collect($this->participants)->map(function($participant){return new OverviewUserResource(User::find($participant->id));}),
            'last_message'=>$this->messages()->orderByDesc('created_at')->first(),
        ];
    }
}

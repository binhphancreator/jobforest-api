<?php

namespace App\Http\Resources;

use App\Models\Project;
use App\Models\Review;
use Illuminate\Http\Resources\Json\JsonResource;

class MyOfferResource extends JsonResource
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
            'project_id'=>$this->pivot->project_id,
            'user_id'=>$this->pivot->user_id,
            'cost'=>$this->pivot->cost,
            'completion_time'=>$this->pivot->completion_time,
            'description'=>$this->pivot->description,
            'status'=>$this->pivot->status,
            'file'=>$this->pivot->file,
            'created_at'=>$this->pivot->created_at,
            'updated_at'=>$this->pivot->updated_at,
            'project'=>Project::findOrFail($this->pivot->project_id),
            'review'=>Review::where(['project_id'=>$this->pivot->project_id,'user_id'=>$this->pivot->user_id])->first()
        ];
    }
}

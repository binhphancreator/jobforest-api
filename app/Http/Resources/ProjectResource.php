<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->loadMissing(['skills','offers','user']);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'content'=>$this->content,
            'deadline_bids'=>$this->deadline_bids,
            'type_work'=>$this->type_work,
            'work_form'=>$this->work_form,
            'location'=>$this->location,
            'salary_type'=>$this->salary_type,
            'budget_min'=>$this->budget_min,
            'budget_max'=>$this->budget_max,
            'expertise_id'=>$this->expertise_id,
            'service_id'=>$this->service_id,
            'slug'=>$this->slug,
            'user_id'=>$this->user_id,
            'file'=>$this->file,
            'status'=>$this->status,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'skills'=>$this->skills->map(function($skill){return $skill->id;}),
            'offers'=>new OfferCollection($this->offers->where('pivot.status','!=','accepted')),
            'accepted_offer'=>new OfferResource($this->offers->where('pivot.status','accepted')->sortByDesc('created_at')->first()),
            'user'=>new OverviewUserResource($this->user),
            'review'=>$this->review
        ];
    }
}

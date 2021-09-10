<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OverviewUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $preserveKeys = true;
    public function toArray($request)
    {
        $this->loadMissing(['personalInfo','profile','portfolios','reviews','reviews.project','skills','services']);
        return [
            'id'=>$this->id,
            'fullname'=>$this->fullname,
            'slug'=>$this->slug,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'avatar'=>$this->personalInfo->avatar,
            'city'=>$this->personalInfo->city,
            'idnumber'=>$this->personalInfo->idnumber,
            'birth'=>$this->personalInfo->birth,
            'address'=>$this->personalInfo->address,
            'profile'=>collect($this->profile),
            'portfolios'=>collect($this->portfolios),
            'reviews'=>$this->reviews,
            'skills'=>collect($this->skills)->map(function($skill){return $skill->id;}),
            'services'=>collect($this->services)->map(function($service){return $service->id;})
        ];
    }
}

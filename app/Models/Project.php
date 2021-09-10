<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Skill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey='id';
    protected $table='projects';

    protected function asTimestamp($value)
    {
        return Carbon::create($value)->format('Y-m-d');
    }

    protected $fillable = [
        'name',
        'content',
        'deadline_bids',
        'type_work',
        'work_form',
        'location',
        'salary_type',
        'budget_min',
        'budget_max',
		'expertise_id',
		'service_id',
		"slug",
		'user_id',
        'file',
        'status',
    ];

    protected $attributes=[
        'status'=>'offering'
    ];

	public function skills()
    {
        return $this->belongsToMany(Skill::class,"projects_skills",'project_id','skill_id');
    }

    public function offers(){
        return $this->belongsToMany(User::class,"offers",'project_id','user_id')
                    ->withTimestamps()
                    ->withPivot(['cost','completion_time','description','file','status']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateStatus($status){
	    $this->update(['status'=>$status]);
    }

    public function updateFile($path){
        if($this->file) Storage::delete($this->file);
        $this->update(['file' => $path]);
        $this->refresh();
    }

    public function acceptOffer($id){
	    $this->updateStatus('working');
        $this->offers()->update(['status'=>'rejected']);
        $this->offers()->updateExistingPivot($id,['status'=>'accepted']);
    }

    public function forceDelete()
    {
        if($this->file) Storage::delete($this->file);
        return parent::forceDelete();
    }

    public function updateFileOffer($user_id,$path){
        $this->offers()->updateExistingPivot($user_id,['file'=>$path]);
        $this->refresh();
    }

    public function review(){
	    return $this->hasOne(Review::class,'project_id');
    }

    protected static function booted()
    {
        static::created(function($project){
            $slug = Str::slug($project['name']."-".$project['id']);
            $project->update(['slug'=>$slug]);
        });
    }
}

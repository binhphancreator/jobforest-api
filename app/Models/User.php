<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Project;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens,HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'fullname',
        'slug',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::created(function($user){
            $slug = Str::slug($user->fullname."-".$user->id);
            $user->update(['slug'=>$slug]);
            $user->personalInfo()->create();
            $user->profile()->create();
            $user->assignRole("user");
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function projects(){
		return $this->hasMany(Project::class,"user_id");
	}

	public function personalInfo(){
        return $this->hasOne(PersonalInfo::class,'user_id');
    }

    public function profile(){
        return $this->hasOne(Profile::class,'user_id');
    }

    public function portfolios(){
        return $this->hasMany(Portfolio::class,'user_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class,'user_id');
    }

    public function skills(){
	    return $this->belongsToMany(Skill::class,'users_skills');
    }

    public function services(){
        return $this->belongsToMany(Service::class,'users_services');
    }

    public function conversations(){
        return $this->belongsToMany(Conversation::class,'participants')->as('conversations');
    }

    public function messages(){
	    return $this->hasMany(Message::class,'sender_id');
    }

    public function offers(){
        return $this->belongsToMany(Project::class,"offers",'user_id','project_id')
            ->withTimestamps()
            ->withPivot(['cost','completion_time','description','file','status']);
    }

    public function conversationWith(User $user){
	    try{
	        $conversation = $this->conversations()->whereIn('id',$user->conversations->map(function($conversation){return $conversation->id;}))->firstOrFail();
	    }
        catch (ModelNotFoundException $e){
	        $conversation = Conversation::create();
	        $conversation->participants()->sync([$this->id,$user->id]);
        }
        return $conversation;
    }
}

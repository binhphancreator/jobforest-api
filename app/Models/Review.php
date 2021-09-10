<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table='reviews';
    protected $fillable=[
        'user_id',
        'project_id',
        'title',
        'content',
        'star',
    ];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
}

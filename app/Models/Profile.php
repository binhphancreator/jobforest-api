<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $primaryKey = 'user_id';

    protected  $fillable=[
        'user_id',
        'type',
        'title',
        'introduction',
        'website',
        'expertise_id',
        'qualification',
    ];

    protected $attributes = [
        'type' => 'Freelancer',
    ];
}

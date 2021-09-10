<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;
    protected $table = 'personal_infos';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'numberphone',
        'city',
        'idnumber',
        'birth',
        'address',
        'avatar',
    ];

    protected $attributes = [
        'avatar' => 'public/default.svg',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}

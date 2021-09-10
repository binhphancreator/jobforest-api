<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasFactory;
    protected $table='portfolios';
    protected $fillable=[
        'user_id',
        'title',
        'file',
        'url',
        'description',
        'slug'
    ];

    protected static function booted()
    {
        static::created(function($portfolio){
            $slug = Str::slug($portfolio['title']."-".$portfolio['id']);
            $portfolio->update(['slug'=>$slug]);
        });
    }
}

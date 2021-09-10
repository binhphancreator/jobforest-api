<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = [
        'sender_id',
        'conversation_id',
        'message',
        'type',
    ];

    protected $attributes = [
        'type' => 'text',
    ];

    public function conversation(){
        return $this->belongsTo(Conversation::class,'conversation_id');
    }

    public function receivers(){
        return $this->conversation->participants()->where('id','!=',$this->sender_id);
    }
}

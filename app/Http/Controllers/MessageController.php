<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    public function store(Request $req){
        $message = $req->user()->messages()->create($req->only('conversation_id','message'));
        if(!$id = $req->receiver_id) $id = $message->receivers()->firstOrFail()->id;
        broadcast(new SendMessageEvent($message,$id));
        return new MessageResource($message);
    }

    public function index(Request $req){
        return new MessageCollection(Conversation::find($req->input('id'))->messages()->orderByDesc('created_at')->simplePaginate(15));
    }
}

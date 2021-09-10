<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationCollection;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConversationController extends Controller
{
    public function create(Request $req){
        $conversation = $req->user()->conversationWith(User::find($req->id));
        return new ConversationResource(Conversation::find($conversation->id));
    }

    public function index(Request $req){
        return new \App\Http\Resources\ConversationCollection($req->user()->conversations()->simplePaginate(15));
    }
}

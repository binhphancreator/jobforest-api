<?php

namespace App\Http\Controllers;

use App\Models\Expertise;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TagController extends Controller
{
    public function index(){
        return collect(['expertises'=>Expertise::orderBy('name')->get(),'skills'=>Skill::orderBy('name')->get(),'services'=>Service::orderBy('name')->get()]);
    }
}

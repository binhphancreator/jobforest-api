<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Http\Resources\MessageResource;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function post(Request $req){
        $project = $req->user()->projects()->create($req->only('name','content','deadline_bids','type_work','work_form','location','salary_type','budget_min','budget_max','expertise_id','service_id'));
        $project = Project::find($project->id);
        $project->skills()->sync(explode(',',$req->skills));

        if($req->file('file')) {
            $project->update(['file' => $req->file('file')->store('projects')]);
            $project->refresh();
        }
        return $project;
    }

    public function getBySlug(Request $req,$slug){
        $project = Project::with(['skills','offers','user','user.personalInfo','user.profile'])->where('slug',$slug)->firstOrFail();
        return new ProjectResource($project);
    }

    public function update(Request $req){
        $project = Project::findOrFail($req->input('id'));
        Gate::authorize('update',$project);

        $project->update($req->only('name','content','deadline_bids','type_work','work_form','location','salary_type','budget_min','budget_max','fields_id','service_id'));
        $project->skills()->sync(explode(',',$req->skills));
        if($req->file('file'))  $project->updateFile($req->file('file')->store('projects'));
        return $project;
    }

    public function delete(Request $req){
        $project =Project::findOrFail($req->input('id'));
        Gate::authorize('delete',$project);
        return $project->forceDelete();
    }

    public function view(Request $req){
        return new ProjectCollection($req->user()->projects);
    }

    public function offer(Request $req){
        $project = Project::find($req->id);
        Gate::authorize('offer',$project);

        $project->offers()->attach([$req->user()->id => $req->only('cost','completion_time','description')]);
        if($req->file('file'))  $project->updateFileOffer($req->user()->id,$req->file('file')->store('offers'));
        return $project->offers;
    }

    public function acceptOffer(Request $req){
        Project::findOrFail($req->project_id)->acceptOffer($req->user_id);
        $conversation = $req->user()->conversationWith(User::findOrFail($req->user_id));
        $message = $conversation->messages()->create(['message'=>'Offer của bạn vừa được nhà tuyển dụng chấp nhận.Hãy trao đổi thêm với nhà tuyển dụng ở đây nhé','sender_id'=>$req->user()->id]);
        broadcast(new SendMessageEvent($message,$req->user_id));
        return null;
    }

    public function updateStatus(Request $req){
        $project = Project::findOrFail($req->input('id'));
        Gate::authorize('update',$project);

        $project->updateStatus($req->input('status'));
        return $project;
    }

    public function rate(Request $req){
        $project = Project::findOrFail($req->input('project_id'));
        Gate::authorize('rate',$project);

        $project->review()->create($req->only('user_id','title','content','star'));
        $project->updateStatus('rated');
        return $project;
    }

    public function all(Request $req){
        //$projects = Project::load('skills')->where('status','offering')->where('deadline_bids','>',now()->format('Y-m-d'));
        $projects = Project::with('skills');
        if($req->input('q')) $projects->where('name','like','%'.$req->input('q').'%');
        if($req->input('services')) $projects->whereIn('service_id',$req->input('services'));
        if($req->input('expertises')) $projects->whereIn('expertise_id',$req->input('expertises'));
        if($req->input('work_form')) $projects->where('work_form',$req->input('work_form'));
        if($req->input('salary_type')) $projects->where('salary_type',$req->input('salary_type'));
        if($req->input('type_work')) $projects->where('type_work',$req->input('type_work'));
        if($req->input('location')) $projects->where('location',$req->input('location'));
        if($req->input('skills')) $projects->whereHas('skills',function($skill) use ($req) {$skill->whereIn('id',$req->input('skills'));});
        if($req->input('newest')) $projects->orderByDesc('created_at');
        if($req->input('status')){
            $projects->where('status',$req->input('status'));
            if($req->input('status') == 'offering') $projects->where('deadline_bids','>',now()->format('Y-m-d'));
        }

        return new ProjectCollection($projects->paginate(20));
    }
}

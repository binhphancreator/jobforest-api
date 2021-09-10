<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyOfferCollection;
use App\Http\Resources\OverviewUserResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function view(Request $req){
        return new UserResource($req->user());
    }

    public function overview(Request $req,$slug){
        return new OverviewUserResource(User::where('slug',$slug)->firstOrFail());
    }

    public function freelancers(Request $req){
        $users = User::with(['personalInfo','profile','portfolios','reviews','skills','services'])
                ->whereHas('profile',function($profile){return $profile->where('type','Freelancer');})
                ->has('skills')
                ->has('services')
                ->whereHas('personalInfo',function($personalInfo){return $personalInfo->where('numberphone','!=',null);})
                ->whereHas('profile',function($profile){return $profile->where('title','!=',null);});

        if($req->input('skills')) $users->whereHas('skills',function($skill) use ($req) {$skill->whereIn('id',$req->input('skills'));});
        if($req->input('location')) $users->whereHas('personalInfo',function($personalInfo) use ($req) {$personalInfo->where('city',$req->input('location'));});
        if($req->input('expertises')) $users->whereHas('profile',function($profile) use ($req) {$profile->whereIn('id',$req->input('expertises'));});
        if($req->input('services')) $users->whereHas('services',function($services) use ($req) {$services->whereIn('id',$req->input('services'));});

        return new UserCollection($users->paginate(20));
    }

    public function register(Request $req){
        if(User::where("email",$req->input('email'))->count()>0)
        return ["message"=>"Email đã tồn tại","status"=>0,];

        $user = User::create(['email'=>$req->input('email'), 'password'=>bcrypt($req->input('password')), 'fullname'=>$req->input('fullname'),]);
        return ["message"=>"Tạo tài khoản thành công","status"=>1];
    }

    public function updateInfo(Request $req){
        $user = $req->user();
        $user->update($req->only('email','fullname'));
        $user->personalInfo()->update($req->only('birth','numberphone','city','idnumber','address'));

        return response()->json(["message"=>"Cập nhật thông tin cá nhân thành công","status"=>1]);
    }

	public function uploadAvatar(Request $req){
        $user = $req->user();
		if($user->personalInfo['avatar'] != "default.svg") Storage::delete($user->personalInfo['avatar']);
        $user->personalInfo()->update(['avatar'=>$req->file('avatar')->store('avatar')]);
		return $user;
	}

	public function updateProfile(Request $req){
        $user = $req->user();
        $user->profile()->update($req->only('type','title','introduction','website','expertise_id','qualification'));
        $user->skills()->sync($req->skills);
        $user->services()->sync($req->services);
        $user->refresh();

        return new UserResource($user);
    }

    public function updatePassword(Request $req){
        $req->user()->update(['password'=>bcrypt($req->input('password'))]);
    }

    public function offers(Request $req){
        return new MyOfferCollection($req->user()->offers);
    }
}

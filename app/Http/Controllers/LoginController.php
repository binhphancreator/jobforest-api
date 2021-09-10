<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __invoke(Request $request)
    {
        if($request->code){
            $this->authGoogle();
            if(Auth::check()) return response('',200);
        }

        if ($request->credential) {
            $this->authGoogleOnetap($request);
            if(Auth::check()) return response('',200);
        }

        if(!Auth::attempt($request->only('email','password'))){
            throw new AuthenticationException();
        }
    }

	public function redirectGoogle(Request $req){
		return Socialite::driver('google')->stateless()->redirect();
	}

	public function authGoogle(){
        try{$userGoogle = Socialite::driver('google')->stateless()->user();} catch(\Exception $e){abort(401);}
        $user = User::where('email',$userGoogle->getEmail())->first();

        if(!$user){
            $user = User::create(['email'=>$userGoogle->getEmail(),'fullname'=>$userGoogle->getName(),'password'=>bcrypt(Str::random(6))]);
            $user->personalInfo()->update(['avatar'=>'avatar/'.Str::uuid()]);$user->refresh();
            Storage::put($user->personalInfo->avatar, file_get_contents($userGoogle->getAvatar()));
        }
        Auth::login($user);
        return $user;
	}

	public function authGoogleOnetap(Request $req){
        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', ['id_token' => $req->credential,]);
        $user = User::where('email',$response['email'])->first();

        if(!$user){
            $user = User::create(['email'=>$response['email'],'fullname'=>$response['fullname'],'password'=>bcrypt(Str::random(6))]);
            $user->personalInfo()->update(['avatar'=>'avatar/'.Str::uuid()]);$user->refresh();
            Storage::put($user->personalInfo->avatar, file_get_contents($response['avatar']));
        }

        Auth::login($user);
        return $user;
    }

    public function logout(Request $req){
        Auth::guard('web')->logout();
        return response()->json('', 204);
    }
}

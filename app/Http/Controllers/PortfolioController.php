<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{

    public function store(Request $req)
    {
        $user = $req->user();
        $user->portfolios()->create($req->only('title','url','description'));
        $path = $req->file('file')->store('portfolios');
        $user->portfolios()->update(['file'=>$path]);

        return new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $req)
    {
        $portfolio =  Portfolio::find($req->id);
        Storage::delete($portfolio->file);
        $portfolio->forceDelete();
        return new UserResource($req->user());
    }
}

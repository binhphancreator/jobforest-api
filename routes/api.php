<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::post("/login",LoginController::class);
Route::middleware('auth:sanctum')->post('/logout',[LoginController::class,'logout']);
Route::get('/auth/google/redirect', [LoginController::class,'redirectGoogle']);
Route::post('/auth/google', [LoginController::class,'authGoogle']);
Route::post("/register",[UserController::class,'register']);
Route::prefix('user')->middleware('auth:sanctum')->group(function(){
    Route::get('/',[UserController::class,'view']);
    Route::get('/overview/{slug}',[UserController::class,'overview'])->withoutMiddleware('auth:sanctum');
    Route::post('/profile/update', [UserController::class,'updateProfile']);
    Route::post('/portfolio/create', [PortfolioController::class,'store']);
    Route::delete('/portfolio/delete', [PortfolioController::class,'destroy']);
    Route::post('/info/update', [UserController::class,'updateInfo']);
    Route::post('/avatar/upload',[UserController::class,'uploadAvatar']);
    Route::post('/password/update',[UserController::class,'updatePassword']);
    Route::get('/offers',[UserController::class,'offers']);
});
Route::prefix('user/project')->middleware('auth:sanctum')->group(function(){
    Route::post('/post', [ProjectController::class,'post']);
    Route::get('/',[ProjectController::class,'view']);
    Route::post('/update',[ProjectController::class,'update']);
    Route::post('/rate',[ProjectController::class,'rate']);
    Route::post('/update/status',[ProjectController::class,'updateStatus']);
    Route::post('/delete',[ProjectController::class,'delete']);
    Route::post('/offer',[ProjectController::class,'offer']);
    Route::post('/offer/accept',[ProjectController::class,'acceptOffer']);
});
Route::prefix('message')->middleware('auth:sanctum')->group(function(){
    Route::post('/send',[MessageController::class,'store']);
    Route::get('/',[MessageController::class,'index']);
});
Route::prefix('conversation')->middleware('auth:sanctum')->group(function(){
    Route::post('/create',[ConversationController::class,'create']);
    Route::get('/',[ConversationController::class,'index']);
});
Route::get('project/{slug}',[ProjectController::class,'getBySlug']);
Route::get('projects',[ProjectController::class,'all']);
Route::get('freelancers',[UserController::class,'freelancers']);
Route::get('/tags',[TagController::class,'index']);

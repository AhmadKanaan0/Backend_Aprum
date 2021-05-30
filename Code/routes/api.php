<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebServices\ProjectWebService;
use App\Http\Controllers\WebServices\LoginWebService;
use App\Http\Controllers\WebServices\ServicesQuestionsWebServices;
use App\Http\Controllers\WebServices\ServicesWebService;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getProjectById/{id}',[ProjectWebService::class, "getProjectById_API"]);

Route::get('getProjectByCategory/{category}',[ProjectWebService::class, "getProjectByCategory_API"]);

Route::post('addProject',[ProjectWebService::class, "addProject_API"]);

Route::get('getCategoryContent/{categoryId}',[ProjectWebService::class,"getCategoryContent_API"]);

Route::get('getRootCategories',[ProjectWebService::class,"getRootCategories_API"]);

Route::get('getAllCategories',[ProjectWebService::class,"getAllCategories_API"]);

Route::get('getCategoryName/{catId}',[ProjectWebService::class,"getCategoryName_API"]);

Route::post('SubscriberRegister',[LoginWebService::class,"SubscriberRegister_API"]);

Route::post("login", [LoginWebService::class, "loginValidation_API"]);

Route::get('getBlogHeadline',[ProjectWebService::class,"getBlogHeadline_API"]);

Route::post("signUp", [LoginWebService::class, "SignUp_API"]);







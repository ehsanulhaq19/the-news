<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ArticleCategoryController;
use App\Http\Controllers\Api\ArticleAuthorController;
use App\Http\Controllers\Api\ArticleSourceController;
use App\Http\Controllers\Api\UserPrefrenceController;

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

Route::prefix('/v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware(['auth:sanctum'])->group(function () {
        //Article
        Route::get('/articles-by-categories', [ArticleController::class, 'getArticleCollection']);
        Route::get('/articles-search', [ArticleController::class, 'getArticleSearchCollection']);
        //UserPrefrence
        Route::post('/user-prefrences', [UserPrefrenceController::class, 'postUserPrefrenceItem']);
        Route::get('/user-prefrences', [UserPrefrenceController::class, 'getUserPrefrenceItem']);
        //ArticleCategory
        Route::get('/article-categories', [ArticleCategoryController::class, 'getArticleCategoriesCollection']);
        //ArticleAuthor
        Route::get('/article-authors', [ArticleAuthorController::class, 'getArticleAuthorsCollection']);
        //ArticleCategory
        Route::get('/article-sources', [ArticleSourceController::class, 'getArticleSourcesCollection']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

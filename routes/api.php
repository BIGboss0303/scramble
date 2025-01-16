<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('/posts')->controller(PostController::class)->group(function(){
    Route::get('/','index');
    Route::post('/','store');
    Route::put('/','update');
    Route::delete('/{post}','destroy')->whereNumber('post');
    Route::get('/{post}','show')->whereNumber('post');

});

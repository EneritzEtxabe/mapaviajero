<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebPaisController;

Route::get('/', function () {
    return view('welcome');
});

<?php

use App\Http\Controllers\Api\Auth\LoginUser;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginUser::class);

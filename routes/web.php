<?php

use App\Http\Controllers\MovieController;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// alow page to render as get.
Route::get('find-movie', function () {
    return view('find-movie');
});

// Route::post('ping', function (Request $request, MovieController $controller) {

//Logic in Movie Controller
 Route::post('find-movie',  [MovieController::class , 'index', ] );

// Quick lookup for fun
Route::post('lucky', function (Request $request) {
    $lucky = Movie::all()->random(1);
    $lucky = $lucky->first()->toArray();
    return view('find-movie')->withLucky($lucky);
});


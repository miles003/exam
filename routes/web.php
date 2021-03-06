<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::delete('calendar', [CalendarController::class,'destroy']);
Route::resource('calendar', CalendarController::class);

Route::get('/{any}', 
    function () {
        return view('welcome');
    }
)->where('any', '.*');

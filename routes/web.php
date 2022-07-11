<?php

use App\Http\Controllers\BulkmailController;
use App\Http\Controllers\EmailController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [BulkmailController::class, 'index'])->name('home');
Route::get('/get-item', [BulkmailController::class, 'getItem'])->name('get.item');


Route::post('/mail_submit', [BulkmailController::class, 'mailSubmit'])->name('mail_submit');

Route::post('/send_email', [BulkmailController::class, 'sendEmail'])->name('sendEmail');

// Route::post('/save_email', [EmailController::class, 'saveEmail'])->name('save_email');

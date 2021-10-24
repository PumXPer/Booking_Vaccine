<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BooksController;

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
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/auth/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/auth/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'registerForm'])->name('register-form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/vaccine',[VaccineController::class ,'list'])->name('vaccine-list');
Route::get('/vaccine/create',[VaccineController::class ,'createForm'])->name('vaccine-create-form');
Route::post('/vaccine/create',[VaccineController::class ,'create'])->name('vaccine-create');
Route::get('/vaccine/{vaccineCode}/update',[VaccineController::class ,'updateForm'])->name('vaccine-update-form');
Route::post('/vaccine/{vaccineCode}/update',[VaccineController::class ,'update'])->name('vaccine-update');
Route::get('/vaccine/{vaccineCode}/delete',[VaccineController::class ,'delete'])->name('vaccine-delete');
Route::get('/vaccine/{vaccineCode}/hospital',[VaccineController::class, 'manageHospital'])->name('vaccine-manage-hospital');
Route::get('/vaccine/{vaccineCode}/hospital/add',[VaccineController::class, 'addHospitalForm'])->name('vaccine-add-hospital-form');
Route::post('/vaccine/{vaccineCode}/hospital/add',[VaccineController::class, 'addHospital'])->name('vaccine-add-hospital');
Route::get('/vaccine/{vaccineCode}/hospital/{hospitalCode}/remove', [VaccineController::class, 'removeHospital'])->name('vaccine-remove-hospital');
Route::get('/vaccine/{vaccineCode}',[VaccineController::class ,'detail'])->name('vaccine-detail');

Route::get('/hospital',[HospitalController::class ,'list'])->name('hospital-list');
Route::get('/hospital/create',[HospitalController::class ,'createForm'])->name('hospital-create-form');
Route::post('/hospital/create',[HospitalController::class ,'create'])->name('hospital-create');
Route::get('/hospital/{hospitalCode}/update',[HospitalController::class ,'updateForm'])->name('hospital-update-form');
Route::post('/hospital/{hospitalCode}/update',[HospitalController::class ,'update'])->name('hospital-update');
Route::get('/hospital/{hospitalCode}/delete',[HospitalController::class ,'delete'])->name('hospital-delete');
Route::get('/hospital/{hospitalCode}/vaccine',[HospitalController::class, 'manageVaccine'])->name('hospital-manage-vaccine');
Route::get('/hospital/{hospitalCode}/vaccine/add',[HospitalController::class, 'addVaccineForm'])->name('hospital-add-vaccine-form');
Route::post('/hospital/{hospitalCode}/vaccine/add',[HospitalController::class, 'addVaccine'])->name('hospital-add-vaccine');
Route::get('/hospital/{hospitalCode}/vaccine/{vaccineCode}/remove', [HospitalController::class, 'removeVaccine'])->name('hospital-remove-vaccine');
Route::get('/hospital/{hospitalCode}',[HospitalController::class ,'detail'])->name('hospital-detail');

Route::get('/type',[TypeController::class ,'list'])->name('type-list');
Route::get('/type/create',[TypeController::class ,'createForm'])->name('type-create-form');
Route::post('/type/create',[TypeController::class ,'create'])->name('type-create');
Route::get('/type/{typeCode}/update',[TypeController::class ,'updateForm'])->name('type-update-form');
Route::post('/type/{typeCode}/update',[TypeController::class ,'update'])->name('type-update');
Route::get('/type/{typeCode}/delete',[TypeController::class ,'delete'])->name('type-delete');
Route::get('/type/{typeCode}/vaccine',[TypeController::class, 'manageVaccine'])->name('type-manage-vaccine');
Route::get('/type/{typeCode}/vaccine/add',[TypeController::class, 'addVaccineForm'])->name('type-add-vaccine-form');
Route::post('/type/{typeCode}/vaccine/add',[TypeController::class, 'addVaccine'])->name('type-add-vaccine');
Route::get('/type/{typeCode}',[TypeController::class ,'detail'])->name('type-detail');

Route::get('/user',[UserController::class ,'list'])->name('user-list');
Route::get('/user/create',[UserController::class ,'createForm'])->name('user-create-form');
Route::post('/user/create',[UserController::class ,'create'])->name('user-create');
Route::get('/user/{email}/update',[UserController::class ,'updateForm'])->name('user-update-form');
Route::post('/user/{email}/update',[UserController::class ,'update'])->name('user-update');
Route::get('/user/{email}/delete',[UserController::class ,'delete'])->name('user-delete');
Route::get('/user/{email}',[UserController::class ,'detail'])->name('user-detail');

Route::get('/account',[AccountController::class ,'detail'])->name('account-detail');
Route::get('/account/update',[AccountController::class ,'updateForm'])->name('account-update-form');
Route::post('/account/update',[AccountController::class ,'update'])->name('account-update');

Route::get('/books',[BooksController::class ,'list'])->name('books-page');
Route::get('/books/detail',[BooksController::class ,'detail'])->name('books-detail');
Route::get('/books/{hospitalCode}/create',[BooksController::class ,'createForm'])->name('books-create-form');
Route::post('/books/{hospitalCode}/create',[BooksController::class ,'create'])->name('books-create');
Route::get('/books/{hospitalCode}/update',[BooksController::class ,'updateForm'])->name('update-form');
Route::post('/books/{hospitalCode}/update',[BooksController::class ,'update'])->name('books-update');




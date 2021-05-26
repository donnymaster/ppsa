<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\User\DoctorController;
use App\Http\Controllers\Recipe\IngredientController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductInfoController;
use App\Http\Controllers\RationController;
use App\Http\Controllers\Recipe\RecipeController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'verify' => false,
    'reset' => false,
]);

// ------- pages for everyone ------
Route::get('/', [BlogController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/doctor-search', [DoctorController::class, 'search'])->name('doctor.search');
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.get');
Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('doctor.get');
Route::get('/doctors/file/{id}', [DoctorController::class, 'getFile'])->name('doctor.file');
Route::get('/directory', [DirectoryController::class, 'index'])->name('directory');
Route::get('/products-info', [ProductController::class, 'info'])->name('product.info');
Route::get('/product-info/{id}', [ProductController::class, 'fullInfo'])->name('product.fullInfo');
Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredient.index');
Route::get('/verify', [DoctorController::class, 'verify'])->name('doctor.verify');
Route::get('/recipe', [RecipeController::class, 'index'])->name('recipe.index');
Route::get('/recipe/show/{recipe}', [RecipeController::class, 'show'])->name('recipe.show');
Route::get('/doctor/register', [DoctorController::class, 'create'])->name('doctor.create');
Route::post('/doctor/register', [DoctorController::class, 'store'])->name('doctor.store');

Route::group(['middleware' => ['auth', 'verify.doctor']], function () {
    // ------- pages for users --------
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account', [AccountController::class, 'index'])->name('account.update');

    Route::get('/messanger', [MessengerController::class, 'index'])->name('messanger.index');
    Route::get('/messanger/messages/{roomId}', [MessengerController::class, 'getMessages'])->name('messanger.messages');
    Route::post('/messanger/messages', [MessengerController::class, 'sendMessage'])->name('messanger.sendMessage');

    Route::get('/room', [MessengerController::class, 'loadRoom'])->name('messenger.room');
    Route::get('/room/{id}', [MessengerController::class, 'getRoom'])->name('messenger.get.room');

    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/ration/search', [RationController::class, 'search'])->name('ration.search');
    Route::get('/ration/events', [RationController::class, 'events'])->name('ration.events');
    Route::post('/ration/events', [RationController::class, 'store'])->name('ration.store');
    Route::put('/ration/events/update/{ration}', [RationController::class, 'update'])->name('ration.events.upate');
    Route::get('/ration/events/delete/{ration}', [RationController::class, 'delete'])->name('ration.events.delete');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::get('/recipe-search', [RecipeController::class, 'search'])->name('recipe.search');

    // ------- pages for doctors ------
    Route::group(['middleware' => 'doctor'], function () {
        Route::post('/doctor/ration/events', [RationController::class, 'doctorCreateRation'])
            ->name('doctor.create.ration');
        Route::resource('/recipe', 'Recipe\RecipeController')->except(['index', 'show']);
        Route::resource('/blog', 'BlogController')->except(['index', 'show', 'create'])->names('blog');
        Route::get('/blog/doctor/my', [BlogController::class, 'my'])->name('blog.my');
        Route::post('/product-info/create', [ProductInfoController::class, 'store'])->name('product-info.store');
        Route::get('/doctor/active/{doctor}', [DoctorController::class, 'activate'])->name('doctor.activate');
        Route::get('/doctor/suspend/{doctor}', [DoctorController::class, 'suspend'])->name('doctor.suspend');
        Route::get('/recipe/delete/ingredient/{ingredient}', [RecipeController::class, 'deleteIngredient'])
            ->name('recipe.delete.ingredient');
        Route::get('/recipe/delete/step/{step}', [RecipeController::class, 'deleteStep'])->name('recipe.delete.step');
        Route::get('/blog/doctor/create', [BlogController::class, 'create'])->name('blog.create');
    });
});

Route::view('/routes', 'routes');

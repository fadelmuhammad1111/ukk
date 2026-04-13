<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process')
    ->middleware('guest');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ITEMS (ADMIN + STAFF)
    |--------------------------------------------------------------------------
    */

    Route::get('items', [ItemController::class, 'index'])
        ->name('items.index');

    Route::get('items/create', [ItemController::class, 'create'])
        ->name('items.create');

    Route::post('items', [ItemController::class, 'store'])
        ->name('items.store');

    // DETAIL BORROW HARUS DI ATAS show()
    Route::get('items/{item}/borrow-detail', [ItemController::class, 'borrowDetail'])
        ->name('items.borrowDetail');

    Route::get('items/{item}', [ItemController::class, 'show'])
        ->name('items.show');


    /*
    |--------------------------------------------------------------------------
    | ITEMS ADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::get('items/{item}/edit', [ItemController::class, 'edit'])
            ->name('items.edit');

        Route::put('items/{item}', [ItemController::class, 'update'])
            ->name('items.update');

        Route::delete('items/{item}', [ItemController::class, 'destroy'])
            ->name('items.destroy');

        Route::post('items/{item}/damaged', [ItemController::class, 'addDamaged'])
            ->name('items.addDamaged');
    });


    /*
    |--------------------------------------------------------------------------
    | CATEGORIES (ADMIN ONLY)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
    });


    /*
    |--------------------------------------------------------------------------
    | BORROWINGS (STAFF ONLY)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:staff')->group(function () {

        Route::resource('borrowings', BorrowingController::class)
            ->except(['edit', 'update']);

        Route::post('borrowings/{id}/return', [BorrowingController::class, 'returnItem'])
            ->name('borrowings.return');
    });


    /*
    |--------------------------------------------------------------------------
    | USERS (ADMIN + STAFF VIEW)
    |--------------------------------------------------------------------------
    */

    Route::get('users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('users/{user}', [UserController::class, 'show'])
        ->name('users.show');


    /*
    |--------------------------------------------------------------------------
    | USERS ADMIN ONLY ACTION
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::resource('users-admin', UserController::class)
            ->except(['index', 'show']);

        Route::post('users/{user}/password', [UserController::class, 'updatePassword'])
            ->name('users.updatePassword');
    });


    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    Route::get('users-export', [UserController::class, 'export'])
        ->name('users.export');

    Route::get('items-export', [ItemController::class, 'export'])
        ->name('items.export');

    Route::get('borrowings-export', [BorrowingController::class, 'export'])
        ->name('borrowings.export');
});

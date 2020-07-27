<?php

use Illuminate\Http\Request;
use App\Book;
use App\Http\Resources\Books as BookResourceCollection;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware(['throttle:10,1', 'cors'])->group(function () {
//   Route::get('buku/{judul}', 'BookController@cetak');
// });

Route::prefix('v1')->group(function () {
  // Public Access
  Route::post('login', 'AuthController@login');
  Route::post('register', 'AuthController@register');

  Route::get('categories/random/{count}', 'CategoryController@random');
  Route::get('categories', 'CategoryController@index');
  Route::get('categories/slug/{slug}', 'CategoryController@slug');

  Route::get('books/top/{count}', 'BookController@top');
  Route::get('books', 'BookController@index');
  Route::get('books/slug/{slug}', 'BookController@slug');
  Route::get('books/search/{keyword}', 'BookController@search');

  Route::get('provinces', 'ShopController@provinces');
  Route::get('cities', 'ShopController@cities');
  Route::get('couriers', 'ShopController@couriers');
  // Route::get('/books', function () {
  //   $books = Book::paginate(5);
  //   return new BookResourceCollection($books);
  // });

  // Private Access
  Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('shipping', 'ShopController@shipping');
    Route::post('services', 'ShopController@services');
    Route::post('payment', 'ShopController@payment');
    Route::get('my-order', 'ShopController@myOrder');
  });
});

// Route::get('/book', function(){
//   return new BookResource(Book::find(1));
// });

// Route::resource('categories', 'CategoryController');
// Route::resource('categories', 'CategoryController')->only([
//   'index', 'show'
// ]);

// Route::resource('categories', 'CategoryController')->except([
//   'create', 'store', 'update', 'destroy'
// ]);

// Route::apiResources([
//   'categories' => 'CategoryController',
//   'books' => 'BookController',
// ]);


// Route::resource([
//   'categories' => 'CategoryController',
//   'books' => 'BookController',
// ]);

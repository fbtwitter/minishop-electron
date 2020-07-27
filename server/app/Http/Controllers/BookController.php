<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Book;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Books as BookResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BookController extends Controller
{

  public function top($count)
  {
    $criteria = Book::select('*')
      ->orderBy('views', 'DESC')
      ->limit($count)
      ->get();

    return new BookResourceCollection($criteria);
  }

  public function index()
  {

    $criteria = Book::paginate(6);
    $results = new BookResourceCollection($criteria);

    return $results;
  }

  public function slug($slug)
  {
    $criteria = Book::where('slug', $slug)->first();
    $criteria->views = $criteria->views + 1;
    $criteria->save();

    return new BookResource($criteria);
  }

  public function search($keyword)
  {
    $criteria = Book::select('*')
      ->where('title', 'LIKE', "%" . $keyword . "%")
      ->orderBy('views', 'DESC')
      ->get();

    return new BookResourceCollection($criteria);
  }
}

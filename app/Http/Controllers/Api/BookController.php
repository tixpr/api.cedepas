<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController extends Controller
{
	public function index(Request $request)
	{
		$query = Book::orderBy('id','desc');
		if (!empty($request->search)){
			$query->where('title_editor', 'LIKE', "%{$request->search}%")->orWhere('author', 'LIKE', "%{$request->search}%");
		}
		$books = $query->paginate(50);
		return BookResource::collection($books);
	}
	public function postBook(Request $request)
	{
		$book = Book::create([
			'code' => $request->code,
			'author' => $request->author,
			'title_editor' => $request->title_editor
		]);
		return new BookResource($book);
	}
	public function putBook(Request $request, $book_id)
	{
		$book = Book::findOrFail($book_id);
		$book->code = $request->code;
		$book->author = $request->author;
		$book->title_editor = $request->title_editor;
		$book->save();
		return new BookResource($book);
	}
	public function deleteBook(Request $request, $book_id)
	{
		$book = Book::findOrFail($book_id);
		$book->delete();
		return response()->json([]);
	}
}

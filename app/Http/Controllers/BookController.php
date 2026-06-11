<?php

namespace App\Http\Controllers;

use App\Services\Contracts\BookServiceInterface;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookServiceInterface $bookService
    ) {}

    public function list(Request $request)
    {
        $books = $this->bookService->getList();
        return view('admin.book.list', [
            'title' => 'Danh sách sách',
            'header' => 'Danh sách sách',
            'books' => $books
        ]);
    }
}

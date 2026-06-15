<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
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

    public function create()
    {
        $formData = $this->bookService->getCreateFormData();

        return view('admin.book.create', [
            'title' => 'Thêm mới sách',
            'header' => 'Thêm mới sách',
            'authors' => $formData['authors'],
            'categories' => $formData['categories'],
        ]);
    }

    public function store(BookRequest $request)
    {
        $this->bookService->create(
            $request->validated(),
            $request->file('cover_image')
        );

        return redirect()
            ->route('admin.book.list')
            ->with('success', 'Thêm sách mới thành công.');
    }

    public function detail(int $id)
    {
        $book = $this->bookService->getBookDetail($id);

        return view('admin.book.detail', [
            'title' => 'Chi tiết sách',
            'header' => 'Chi tiết sách',
            'book' => $book,
        ]);
    }

    public function delete(int $id)
    {
        $this->bookService->delete($id);

        return redirect()
            ->route('admin.book.list')
            ->with('success', 'Xóa sách thành công.');
    }

    public function edit(int $id)
    {
        $book = $this->bookService->getBookDetail($id);
        $formData = $this->bookService->getCreateFormData();
        
        return view('admin.book.edit', [
            'title' => 'Chỉnh sửa sách',
            'header' => 'Chỉnh sửa sách',
            'book' => $book,
            'authors' => $formData['authors'],
            'categories' => $formData['categories'],
        ]);
    }

    public function update(BookRequest $request, int $id)
    {
        $this->bookService->update(
            $id,
            $request->validated(),
            $request->file('cover_image')
        );

        return redirect()
            ->route('admin.book.list')
            ->with('success', 'Cập nhật sách thành công.');
    }
}

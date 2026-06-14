<?php

namespace App\Services;

use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookService extends BaseService implements BookServiceInterface
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository,
        protected AuthorRepositoryInterface $authorRepository,
        protected CategoryRepositoryInterface $categoryRepository,
    ) {
        parent::__construct($bookRepository);
    }

    public function getList(): Collection
    {
        return $this->all()->load(['author', 'categories'])->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author?->name,
                'categories' => $book->categories->pluck('name')->toArray(),
                'price' => $book->price,
                'publish_date' => $book->publish_date,
                'status' => $book->status,
            ];
        });
    }

    public function getCreateFormData(): array
    {
        return [
            'authors' => $this->authorRepository->all(['id', 'name']),
            'categories' => $this->categoryRepository->all(['id', 'name']),
        ];
    }

    public function create(array $data, $coverImage = null): Model
    {
        $categoryIds = $data['categories'];
        unset($data['categories']);

        $attributes = $this->normalizeBookAttributes($data, $coverImage);

        return $this->bookRepository->createWithCategories($attributes, $categoryIds);
    }

    public function getBookDetail(int $id): Model
    {
        return $this->bookRepository->getBookDetail($id);
    }

    protected function normalizeBookAttributes(array $data, ?UploadedFile $coverImage = null): array
    {
        $quantity = (int) $data['quantity'];

        $attributes = [
            'isbn' => $data['isbn'],
            'title' => $data['title'],
            'author_id' => $data['author_id'],
            'price' => $data['price'],
            'quantity' => $quantity,
            'borrowed_quantity' => 0,
            'available_quantity' => $quantity,
            'publish_date' => $data['publish_date'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
        ];

        if ($coverImage instanceof UploadedFile) {
            $attributes['cover_image'] = $this->uploadCoverImage($coverImage);
        }

        return $attributes;
    }

    protected function uploadCoverImage(UploadedFile $coverImage): string
    {
        $filename = Str::uuid()->toString() . '.' . $coverImage->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('books', $coverImage, $filename);

        return 'books/' . $filename;
    }

    public function delete(int $id): bool
    {
        $book = $this->repository->findOrFail($id);

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        return (bool) $book->delete();
    }
}

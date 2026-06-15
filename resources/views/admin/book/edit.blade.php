@extends('layouts.admin')

@section('title', $title)
@section('header', $header)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
    @php
        if (session()->hasOldInput()) {
            $selectedCategories = old('categories', []);
        } else {
            $selectedCategories = $book->categories->pluck('id')->toArray();
        }

        $selectedCategories = array_map('strval', $selectedCategories);
    @endphp
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Chỉnh sửa sách</h2>
            </div>

            <form action="{{ route('admin.book.update', $book->id) }}" method="POST" enctype="multipart/form-data"
                class="row g-4">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label for="isbn" class="form-label">Mã ISBN <span class="text-danger">*</span></label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                        class="form-control @error('isbn') is-invalid @enderror" placeholder="Nhập mã ISBN">
                    @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="title" class="form-label">Tên sách <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}"
                        class="form-control @error('title') is-invalid @enderror" placeholder="Nhập tên sách">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="author_id" class="form-label">Tác giả <span class="text-danger">*</span></label>
                    <select id="author_id" name="author_id" class="form-select @error('author_id') is-invalid @enderror">
                        <option value="">-- Chọn tác giả --</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" @selected(old('author_id', $book->author_id) == $author->id)>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Giá sách <span class="text-danger">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price', $book->price) }}"
                        step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
                        placeholder="0.00">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $book->quantity) }}"
                        min="0" step="1" class="form-control @error('quantity') is-invalid @enderror"
                        placeholder="0">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="publish_date" class="form-label">Ngày xuất bản <span class="text-danger">*</span></label>
                    <input type="date" id="publish_date" name="publish_date"
                        value="{{ old('publish_date', $book->publish_date?->format('Y-m-d')) }}"
                        class="form-control @error('publish_date') is-invalid @enderror">
                    @error('publish_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="available" @selected(old('status', $book->status) === 'available')>Có sẵn</option>
                        <option value="unavailable" @selected(old('status', $book->status) === 'unavailable')>Đã hết</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label d-block">Thể loại <span class="text-danger">*</span></label>
                    <div
                        class="row g-2 @error('categories') is-invalid @enderror @error('categories.*') is-invalid @enderror">
                        @foreach ($categories as $category)
                            <div class="col-md-4 col-lg-3">
                                <div class="form-check">
                                    <input type="checkbox" id="category_{{ $category->id }}" name="categories[]"
                                        value="{{ $category->id }}"
                                        class="form-check-input @error('categories') is-invalid @enderror @error('categories.*') is-invalid @enderror"
                                        @checked(in_array((string) $category->id, $selectedCategories))>
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('categories')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('categories.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea id="description" name="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror" placeholder="Nhập mô tả sách">{{ old('description', $book->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="cover_image" class="form-label">Ảnh bìa</label>
                    <input type="file" id="cover_image" name="cover_image"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                        class="form-control @error('cover_image') is-invalid @enderror">
                    @error('cover_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div id="cover-preview-wrapper" class="mt-3">
                        <p class="form-label mb-2">Ảnh bìa</p>

                        <img id="cover-preview" src="{{ $book->cover_image ? Storage::url($book->cover_image) : '' }}"
                            alt="Ảnh bìa" class="img-thumbnail {{ $book->cover_image ? '' : 'd-none' }}"
                            style="max-width: 240px; max-height: 320px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Lưu sách</button>
                    <a href="{{ route('admin.book.list') }}" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const coverInput = document.getElementById('cover_image');
            const previewImage = document.getElementById('cover-preview');

            const originalImage = previewImage.src;
            let previewUrl = null;

            coverInput.addEventListener('change', function() {
                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                    previewUrl = null;
                }

                const file = this.files[0];

                if (!file) {
                    if (originalImage) {
                        previewImage.src = originalImage;
                        previewImage.classList.remove('d-none');
                    } else {
                        previewImage.classList.add('d-none');
                    }

                    return;
                }

                previewUrl = URL.createObjectURL(file);

                previewImage.src = previewUrl;
                previewImage.classList.remove('d-none');
            });
        });
    </script>
@endpush

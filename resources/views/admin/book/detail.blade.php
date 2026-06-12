@extends('layouts.admin')

@section('title', $title)
@section('header', $header)

@section('header-actions') <div class="flex items-center gap-3"> <a href="{{ route('admin.book.list') }}"
            class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            ← Quay lại </a>

        <a href="#"
            class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600">
            ✏️ Chỉnh sửa
        </a>

        <form action="{{ route('admin.book.delete', $book->id) }}"
            method="POST"
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa sách này?')"
                class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                🗑️ Xóa
            </button>
        </form>
    </div>


@endsection

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="p-8">
                <div class="grid gap-10 lg:grid-cols-5">

                    {{-- Cover --}}
                    <div class="lg:col-span-2">
                        @if ($book->cover_image)
                            <div class="mx-auto max-w-sm">
                                <div
                                    class="aspect-[3/4] overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="h-full w-full object-cover">
                                </div>
                            </div>
                        @else
                            <div class="mx-auto max-w-sm">
                                <div
                                    class="aspect-[3/4] flex items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 text-slate-400">
                                    Chưa có ảnh bìa
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Main Information --}}
                    <div class="lg:col-span-3">
                        <h1 class="text-4xl font-bold leading-tight text-slate-900">
                            {{ $book->title }}
                            <div class="mb-4">
                                @if ($book->status === 'available')
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-700">
                                        Có sẵn
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-700">
                                        Hết hàng
                                    </span>
                                @endif
                            </div>
                        </h1>

                        <div class="mt-10 grid gap-x-10 gap-y-6 md:grid-cols-2">

                            <div>
                                <p class="text-sm text-slate-500">ISBN</p>
                                <p class="mt-1 font-semibold">
                                    {{ $book->isbn }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Ngày xuất bản</p>
                                <p class="mt-1 font-semibold">
                                    {{ $book->publish_date ? $book->publish_date->format('d/m/Y') : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Số lượng</p>
                                <p class="mt-1 font-semibold">
                                    {{ number_format($book->quantity) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Đã mượn</p>
                                <p class="mt-1 font-semibold">
                                    {{ number_format($book->borrowed_quantity) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Còn lại</p>
                                <p class="mt-1 font-semibold">
                                    {{ number_format($book->available_quantity) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Tác giả</p>
                                <p class="mt-1 font-semibold">
                                    {{ $book->author?->name ?? 'N/A' }}
                                </p>
                            </div>

                        </div>

                        {{-- Categories --}}
                        <div class="mt-10">
                            <h3 class="mb-3 text-sm font-medium text-slate-500">
                                Thể loại
                            </h3>
                            @if ($book->categories->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($book->categories as $category)
                                        <span
                                            class="rounded-full bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-slate-500">
                                    Chưa có thể loại
                                </p>
                            @endif
                        </div>

                        <div class="mt-5">
                            <span class="text-4xl font-bold text-rose-600">
                                {{ number_format($book->price, 0, ',', '.') }} đ
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @if ($book->description)
                    <div class="mt-12 border-t border-slate-200 pt-8">

                        <h2 class="mb-4 text-xl font-semibold text-slate-900">
                            Mô tả sách
                        </h2>

                        <details class="group">
                            <summary
                                class="cursor-pointer list-none rounded-xl bg-slate-50 p-6 font-medium text-slate-700 hover:bg-slate-100">
                                <span class="group-open:hidden">
                                    Xem mô tả
                                </span>

                                <span class="hidden group-open:inline">
                                    Thu gọn
                                </span>
                            </summary>

                            <div class="mt-3 rounded-xl bg-slate-50 p-6 leading-7 text-slate-700 whitespace-pre-line">
                                {{ $book->description }}
                            </div>
                        </details>

                    </div>
                @endif

                {{-- Author Biography --}}
                @if ($book->author && $book->author->biography)
                    <div class="mt-8 border-t border-slate-200 pt-8">

                        <h2 class="mb-4 text-xl font-semibold text-slate-900">
                            Tiểu sử tác giả
                        </h2>

                        <div class="rounded-xl bg-slate-50 p-6 leading-7 text-slate-700">
                            {{ $book->author->biography }}
                        </div>

                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

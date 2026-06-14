@extends('layouts.admin')

@section('title', $title)
@section('header', $header)

@php
    $formattedBooks = $books->map(function ($book) {
        return [
            'id' => $book['id'],
            'title' => $book['title'],
            'author' => $book['author'] ?? 'N/A',
            'categories' => !empty($book['categories']) ? implode(', ', $book['categories']) : 'N/A',
            'price' => number_format($book['price'], 0, ',', '.') . ' đ',
            'publish_date' => $book['publish_date'] ? $book['publish_date']->format('d/m/Y') : 'N/A',
            'status' => $book['status'],
            'status_label' => $book['status'] === 'available' ? 'Có sẵn' : 'Đã hết',
            'status_class' => $book['status'] === 'available' ? 'green' : 'red',
        ];
    });
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Danh sách sách</h2>
            </div>

            <div class="overflow-x-auto">
                <div id="filter-panel" class="row g-3 mb-3 d-none">
                    <div class="col-md-4">
                        <select id="filter-category" class="form-select">
                            <option value="">Tất cả thể loại</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select id="filter-author" class="form-select">
                            <option value="">Tất cả tác giả</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select id="filter-status" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="Có sẵn">Có sẵn</option>
                            <option value="Đã hết">Đã hết</option>
                        </select>
                    </div>
                </div>
                <table id="books-table" class="table table-striped table-bordered w-full">
                    <thead>
                        <tr>
                            <th class="text-left">ID</th>
                            <th class="text-left">Thể loại</th>
                            <th class="text-left">Tên sách</th>
                            <th class="text-left">Tác giả</th>
                            <th class="text-left">Giá</th>
                            <th class="text-left">Trạng thái</th>
                            <th class="text-left">Ngày xuất bản</th>
                            <th class="text-left">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formattedBooks as $book)
                            <tr>
                                <td>{{ $book['id'] }}</td>
                                <td>{{ $book['categories'] }}</td>
                                <td>
                                    <a href="{{ route('admin.book.detail', $book['id']) }}"
                                        class="text-primary text-decoration-none fw-medium">
                                        {{ $book['title'] }}
                                    </a>
                                </td>
                                <td>{{ $book['author'] }}</td>
                                <td>{{ $book['price'] }}</td>
                                <td>
                                    @if ($book['status_class'] === 'green')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">{{ $book['status_label'] }}</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">{{ $book['status_label'] }}</span>
                                    @endif
                                </td>
                                <td>{{ $book['publish_date'] }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- <a href="{{ route('admin.book.edit', $book['id']) }}" --}}
                                        <a href=""
                                            class="btn btn-warning btn-sm">
                                            ✏️
                                        </a>

                                        <form action="{{ route('admin.book.delete', $book['id']) }}"
                                            method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xoá sách này?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#books-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/vi.json'
                },
                pageLength: 10,
                order: [
                    [6, 'desc']
                ],
                initComplete: function() {
                    $('.dataTables_filter').append(`
                        <button type="button"
                            id="toggle-filter"
                            class="btn btn-outline-primary btn-sm ms-2">
                            Lọc
                        </button>

                        <button type="button"
                            class="btn btn-outline-secondary btn-sm ms-2"
                            onclick="window.location.reload();">
                            Làm mới
                        </button>
                    `);

                    [
                        [1, '#filter-category'],
                        [3, '#filter-author']
                    ].forEach(([column, selector]) => {
                        [...new Set(
                            table.column(column)
                                .data()
                                .toArray()
                                .flatMap(value => value.split(',').map(v => v.trim()))
                        )]
                        .sort()
                        .forEach(value => {
                            $(selector).append(
                                `<option value="${value}">${value}</option>`
                            );
                        });
                    });
                }
            });

            $(document).on('click', '#toggle-filter', function() {
                $('#filter-panel').toggleClass('d-none');
            });

            $.fn.dataTable.ext.search.push(function(settings, data) {
                const category = $('#filter-category').val();
                const author = $('#filter-author').val();
                const status = $('#filter-status').val();

                return (
                    (!category || data[1].includes(category)) &&
                    (!author || data[3] === author) &&
                    (!status || data[5].includes(status))
                );
            });

            $('#filter-category, #filter-author, #filter-status')
                .on('change', function() {
                    table.draw();
                });
        });
    </script>
@endpush

@php
    $navItems = [
        [
            'label' => 'Tổng quan',
            'route' => 'admin.dashboard',
            'icon' => 'home',
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'label' => 'Quản lý sách',
            'route' => 'admin.book.list',
            'icon' => 'book',
            'active' => request()->routeIs('admin.book.list'),
        ],
        [
            'label' => 'Thêm mới sách',
            'route' => 'admin.book.create',
            'icon' => '',
            'active' => request()->routeIs('admin.book.create'),
            'roles' => ['admin']
        ],
    ];
@endphp

<aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-slate-200 bg-white lg:flex">
    <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-6">
        <div class="flex size-9 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white">
            {{ strtoupper(substr(config('app.name', 'A'), 0, 1)) }}
        </div>
        <div class="min-w-0">
            <p class="truncate text-sm font-semibold text-slate-900">Thư viện</p>
            <p class="truncate text-xs text-slate-500">Admin</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-4">
        @foreach ($navItems as $item)
            @if (Route::has($item['route']))
                @continue(
                    isset($item['roles'])
                    && ! auth()->user()->hasAnyRole($item['roles'])
                )
                <a
                    href="{{ route($item['route']) }}"
                    @class([
                        'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                        'bg-indigo-50 text-indigo-700' => $item['active'],
                        'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! $item['active'],
                    ])
                >
                    <x-admin.icon :name="$item['icon']" @class([
                        'size-5 shrink-0',
                        'text-indigo-600' => $item['active'],
                        'text-slate-400 group-hover:text-slate-600' => ! $item['active'],
                    ]) />
                    <span class="flex-1 truncate">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <div class="border-t border-slate-200 p-4">
        <div class="mb-3">
            <p class="truncate text-sm font-medium text-slate-900">
                {{ auth()->user()->name }}
            </p>

            <p class="truncate text-xs text-slate-500">
                {{ auth()->user()->email }}
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="group flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50">
                <x-admin.icon name="logout" class="size-5" />
                <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile bottom nav --}}
<nav class="fixed inset-x-0 bottom-0 z-30 flex border-t border-slate-200 bg-white lg:hidden">
    @foreach ($navItems as $item)
        @if (Route::has($item['route']))
            <a
                href="{{ route($item['route']) }}"
                @class([
                    'flex flex-1 flex-col items-center gap-1 py-2 text-[10px] font-medium',
                    'text-indigo-600' => $item['active'],
                    'text-slate-500' => ! $item['active'],
                ])
            >
                <x-admin.icon :name="$item['icon']" class="size-5" />
                <span class="truncate px-1">{{ $item['label'] }}</span>
            </a>
        @endif
    @endforeach
</nav>

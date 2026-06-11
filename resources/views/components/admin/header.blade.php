@props([
    'title' => '',
])

<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="min-w-0">
            @if ($title)
                <h1 class="truncate text-lg font-semibold text-slate-900 sm:text-xl">{{ $title }}</h1>
            @endif
        </div>

        @if (isset($actions))
            <div class="flex shrink-0 items-center gap-2">
                {{ $actions }}
            </div>
        @endif
    </div>
</header>

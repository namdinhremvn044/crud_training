{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Đăng nhập — {{ config('app.name') }}</title>

    @fonts
    <x-vite-assets />
</head>
<body class="min-h-screen bg-slate-50">

<div class="flex min-h-screen items-center justify-center px-4">
    <div class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold">
                Đăng nhập
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Đăng nhập để truy cập hệ thống quản trị
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-600">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label
                    for="email"
                    class="mb-1 block text-sm font-medium text-slate-700"
                >
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none"
                    required
                    autofocus
                    autocomplete="username"
                >
            </div>

            <div>
                <label
                    for="password"
                    class="mb-1 block text-sm font-medium text-slate-700"
                >
                    Mật khẩu
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none"
                    required
                    autocomplete="current-password"
                >
            </div>

            <div class="flex items-center">
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    Ghi nhớ đăng nhập
                </label>
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-slate-900 px-4 py-2 font-medium text-white transition hover:bg-slate-800"
            >
                Đăng nhập
            </button>
        </form>

    </div>
</div>

</body>
</html>
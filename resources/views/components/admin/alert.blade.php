@if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
    <div class="mb-6 space-y-3">
        @if (session('success'))
            <x-admin.alert-item type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-admin.alert-item type="error" :message="session('error')" />
        @endif

        @if (session('warning'))
            <x-admin.alert-item type="warning" :message="session('warning')" />
        @endif

        @if (session('info'))
            <x-admin.alert-item type="info" :message="session('info')" />
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <p class="font-medium">Vui lòng kiểm tra lại thông tin:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    {{-- This is a fallback option when `npm run dev` or `npm run build` isn't running (e.g., Docker doesn't have Node) --}}
    <script src="https://cdn.tailwindcss.com"></script>
@endif

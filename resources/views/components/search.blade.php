<div {{ $attributes }}>
    <div class="flex items-center gap-2
                bg-gray-50 border border-gray-300 rounded-lg
                h-10
                focus-within:ring-2 focus-within:ring-blue-500
                transition shadow-sm" style="padding-left: 14px;">

        <svg class="h-5 w-5 text-gray-400"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>

        <input
            type="text"
            placeholder="{{ $placeholder ?? 'Buscar...' }}"
            class="flex-1 bg-transparent border-none outline-none text-sm"
        />
    </div>
</div>
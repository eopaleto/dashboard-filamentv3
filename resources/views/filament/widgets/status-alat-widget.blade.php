<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $alat = \App\Models\StatusAlat::first();
        @endphp

        <div class="p-4">
            @if ($alat?->status == 1)
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-md">
                    <strong>{{ $alat->nama_alat }}</strong> sedang <span class="font-bold">Online</span>.
                </div>
            @else
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded-md">
                    <strong>{{ $alat?->nama_alat ?? 'Alat' }}</strong> sedang <span class="font-bold">Offline</span>.
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

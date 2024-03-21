<x-filament-panels::page>
    {{-- <x-filament-widgets::widget --}}
     {{-- :widgets="$this->getWidgets()"
     :columns="$this->getColumns()" --}}
    {{-- /> --}}
    {{-- @livewire(\App\Filament\Resources\ClinicResource\Widgets\AppointmentChart::classc) --}}

    @if ($this->hasInfolist())
        {{ $this->infolist }}
    @endif
</x-filament-panels::page>

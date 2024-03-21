<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointment extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;

    protected static string $view = 'filament.pages.appointment.view';

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}

<?php

namespace App\Filament\Resources\ClinicResource\Pages;

use App\Filament\Resources\ClinicResource;
use App\Filament\Resources\ClinicResource\Widgets\AppointmentChart;
use Filament\Resources\Pages\ViewRecord;

class ViewClinic extends ViewRecord
{
    // protected static string $view = 'filament.pages.clinic.view';

    protected static string $resource = ClinicResource::class;

    // public function getColumns(): array
    // {
    //     return [
    //         'name' => 'Name',
    //     ];
    // }

    protected function getHeaderWidgets(): array
    {
        return [
            AppointmentChart::class,
        ];
    }

}

<?php

namespace App\Filament\Resources\ClinicResource\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AppointmentChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    public ?Model $record = null;

    public function getHeading(): string
    {
        return 'Appointments Chart ';
    }

    protected function getRecord(): ?Model
    {
        return $this->record;
    }

    protected function getData(): array
    {
        $clinic = $this->record;
        $appointments = $clinic->appointments();
        $appointmentsQuery = $appointments->getQuery();
        $data = Trend::query($appointmentsQuery)
            ->dateColumn('date')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            // ->sum('date');
            ->count('date');

        // dd($data);

        return [
            'datasets' => [
                [
                    'label' => 'Appointments Rate',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    // 'data' => [2433, 3454, 4566, 3300, 5545, 5765, 6787, 8767, 7565, 8576, 9686, 8996],
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
            // 'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];

        $data = $this->getAppointmentsPerMonth();
        Log::info($data);

        return [
            'datasets' => [
                [
                    'label' => 'Appointments Rate',
                    'data' => $data['appointmentsPerMonth'],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
        // return [
        //     'datasets' => [
        //         [
        //             'label' => 'Appointments Rate',
        //             'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
        //         ],
        //     ],
        //     'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        // // ];
    }

    private function getAppointmentsPerMonth(): array
    {
        $appointments = $this->record->appointments();
        $now = Carbon::now();

        $appointmentsPerMonth = [];
        $months = collect(range(1, 12))->map(function ($month) use ($now, &$appointmentsPerMonth, $appointments) {
            $count = $appointments->whereMonth('date', Carbon::parse(Carbon::create()->month($month)))->count();
            $appointmentsPerMonth[] = $count;

            return $now->month($month)->format('M');
        })->toArray();

        return [
            'appointmentsPerMonth' => $appointmentsPerMonth,
            'months' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

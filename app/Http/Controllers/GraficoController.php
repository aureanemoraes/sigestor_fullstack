<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficoController extends Controller
{
    public function populacao() {
        // $linechartjs = app()->chartjs
        // ->name('lineChartTest')
        // ->type('line')
        // ->size(['width' => 600, 'height' => 200])
        // ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
        // ->datasets([
        //     [
        //         "label" => "My First dataset",
        //         'backgroundColor' => "rgba(38, 185, 154, 0.31)",
        //         'borderColor' => "rgba(38, 185, 154, 0.7)",
        //         "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointHoverBackgroundColor" => "#fff",
        //         "pointHoverBorderColor" => "rgba(220,220,220,1)",
        //         'data' => [65, 59, 80, 81, 56, 55, 40],
        //     ],
        //     [
        //         "label" => "My Second dataset",
        //         'backgroundColor' => "rgba(38, 185, 154, 0.31)",
        //         'borderColor' => "rgba(38, 185, 154, 0.7)",
        //         "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
        //         "pointHoverBackgroundColor" => "#fff",
        //         "pointHoverBorderColor" => "rgba(220,220,220,1)",
        //         'data' => [12, 33, 44, 44, 55, 23, 40],
        //     ]
        // ])
        // ->options(['maintainAspectRatio' => false, 'scales' => [
        //     'yAxes' => [
        //         'min' => 0,
        //         'max' => 100
        //     ],
        // ],]);

        $barchartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 500, 'height' => 500])
            ->labels(['Label 1',])
            ->datasets([
                [
                    "label" => "bb",
                    'backgroundColor' => ['rgba(255, 99, 132)', 'rgba(54, 162, 235)'],
                    'data' => [69]
                ],
                [
                    "label" => "aaa",
                    'backgroundColor' => ['rgba(125, 99, 132)', 'rgba(54, 162, 235)'],
                    'data' => [75]
                ],
            ])
            ->options(['maintainAspectRatio' => false, 'scales' => [
                    'yAxes' => [
                        'min' => 0,
                        'max' => 100,
                        'ticks' => [
                            'stepSize' => 10,
                        ],
                    ],
                ],
            ]);

            $barchartjs2 = app()->chartjs
            ->name('barChartTestAA')
            ->type('bar')
            ->size(['width' => 400, 'height' => 400])
            ->labels(['Label 1',])
            ->datasets([
                [
                    "label" => "bb",
                    'backgroundColor' => ['rgba(255, 99, 132)', 'rgba(54, 162, 235)'],
                    'data' => [69]
                ],
                [
                    "label" => "aaa",
                    'backgroundColor' => ['rgba(125, 99, 132)', 'rgba(54, 162, 235)'],
                    'data' => [75]
                ],
            ])
            ->options(['maintainAspectRatio' => false, 'scales' => [
                    'yAxes' => [
                        'min' => 0,
                        'max' => 100,
                        'ticks' => [
                            'stepSize' => 10,
                        ],
                    ],
                ],
            ]);

    //     $piechartjs = app()->chartjs
    //     ->name('pieChartTest')
    //     ->type('doughnut')
    //     ->size(['width' => 200, 'height' => 100])
    //     ->labels(['Label x', 'Label y'])
    //     ->datasets([
    //         [
    //             'backgroundColor' => ['#FF6384', '#36A2EB'],
    //             'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
    //             'data' => [69, 59]
    //         ]
    //     ])
    //    ->options(['maintainAspectRatio' => false, 'scales' => [
    //                 'y' => [
    //                     'min' => 0,
    //                     'max' => 100
    //                 ],
    //             ],
    //         ]);

        return view('public.graficos.populacao', compact('barchartjs', 'barchartjs2'));
    }
}

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var array $seriesData */

?>
<div class="file-view">

    <?= Highcharts::widget([
        'scripts' => [
            'modules/exporting',
        ],
        'options' => [
            'chart'=> [
                'type'=> 'spline',
                'zoomType' => 'x',
                'width' => 1460,
            ],
            'title' => ['text' => 'Balance'],
            'xAxis' => [
                //'tickInterval' => 1 * 3600 * 1000,
                'type' => 'datetime',
                'dateTimeLabelFormats'=> [
                    'minute'=> '%H:%M<br>%d-%m-%y',
                    'hour'=> '%H:%M<br>%d-%m-%y',
                    'day'=> '%d-%m-%y',
                    'week'=> '%d-%m-%y',
                    'month'=> '%d-%m-%y',
                ],
                'title' => ['text'=> 'Date'],
            ],
            'yAxis' => [
                'title' => ['text' => 'Balance, $'],
            ],
            'tooltip'=> [
                'headerFormat'=> '{series.name}',
                'pointFormat'=> '{point.x: %d-%m-%Y<br>%H:%M:%S} - {point.y: .2f} $',
                'crosshairs' => true,
            ],
            'series' => [[
                'name'=> 'Balance',
                'data' => $seriesData,
            ]],
            'plotOptions'=> [
                'spline'=> [
                    'lineWidth'=> 1,
                    'states'=> [
                        'hover'=> [
                            'lineWidth'=> 2
                        ]
                    ],
                    'marker'=> [
                        'enabled'=> true
                    ],
                ]
            ],
        ]
    ]);
?>

</div>


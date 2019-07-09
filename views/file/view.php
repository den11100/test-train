<?php

use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var array $seriesData */



?>
<div class="file-view">


    <?= Highcharts::widget([
        'options' => [
            'title' => ['text' => 'Balance'],
            'xAxis' => [
                'tickInterval' => 2 * 24 * 3600 * 1000,
                'type' => 'datetime',
                'labels'=> [
                  'format'=> '{value:%d-%m}'
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
            'plotOptions'=> [
                'spline'=> [
                    'marker'=> [
                        'enabled'=> true
                    ]
                ]
            ],
            'series' => [[
                'name'=> 'Balance',
                'data' => $seriesData,
                'marker'=> [
                    'enabled'=> true
                ]
            ]]
        ]
    ]);
?>

</div>


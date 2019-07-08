<?php

use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;

/* @var $this yii\web\View */
/* @var array $seriesData */


?>
<div class="file-view">


    <?= Highcharts::widget([
        'options' => [
            'title' => ['text' => 'ppp'],
            'xAxis' => [
                'type' => 'datetime',
//                'dateTimeLabelFormats' => [
//                    'month'=> '%e. %b',
//                    'year'=> '%b'
//                ],
                'title' => ['text'=> 'Date'],
            ],
            'yAxis' => [
                'title' => ['text' => 'price'],
                'min' => 0
            ],
            'series' => [
                [
                        [1147651200, 0],
                        [1147737600, 0.25],
                        [1147824000, 1.41],
                        [1147910400, 1.64],
                ],
            ]
        ]
    ]);
    ?>

</div>


<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trains';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="train-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Create Train', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'station_start',
            'time_start',
            'station_finish',
            'time_finish',
            [
                'attribute' => 'travel_time',
                'value' => function($data) {
                    return  $data->timeInHoursAndMinutes();
                }
            ],
            'price',
            'company',
            [
                'attribute' => 'schedule',
                'value' => function($data) {
                    return $data->dayLabel();
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

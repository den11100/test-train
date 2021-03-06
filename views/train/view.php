<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Train */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="train-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'station_start',
            'time_start',
            'station_finish',
            'time_finish',
            [
                'attribute' => 'travel_time',
                'value' => $model->timeInHoursAndMinutes(),
            ],
            'price',
            'company',
            [
                'attribute' => 'schedule',
                'value' => $model->dayLabel(),
            ],
        ],
    ]) ?>

</div>

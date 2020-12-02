<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Percent */

$this->title = 'Update Percent: ' . $model->color_id;
$this->params['breadcrumbs'][] = ['label' => 'Percents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->color_id, 'url' => ['view', 'id' => $model->color_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="percent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Train */

$this->title = 'Create Train';
$this->params['breadcrumbs'][] = ['label' => 'Trains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="train-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

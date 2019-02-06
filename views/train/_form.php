<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Train */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="train-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'station_start')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_start')->textInput() ?>

    <?= $form->field($model, 'station_finish')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_finish')->textInput() ?>

    <?= $form->field($model, 'travel_time')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'schedule')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

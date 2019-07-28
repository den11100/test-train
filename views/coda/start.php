<?php

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

/* @var $model \app\models\forms\CodaForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="row">
    <div class="col-md-6">

        <?php $form = ActiveForm::begin(['id' => 'coda-form']); ?>

        <?= $form->field($model, 'url')->textInput() ?>

        <?= $form->field($model, 'period_range')->dropDownList($model->getListPeriods()) ?>

        <?= $form->field($model, 'table_name')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="form-group">
        <div id="progressBarWrap" class="progress progress-striped active" style="visibility: hidden">
            <div id="progressBar" class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                0%
            </div>
        </div>
        </div>

    </div>
</div>

<?php
$this->registerJsFile('@web/js/codaFormHelper.js', [
    'depends' => JqueryAsset::className(),
]);

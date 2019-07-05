<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var array $files */

$this->title = 'My Yii Application';
?>
<div class="file-index">

    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div class="row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'uploadFile')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('upload', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6">
            <?php $i = 0 ?>
            <?php foreach ($files as $file): ?>
                <p><?= ++$i .") ". $file ?> <a href="<?= Url::to(['file/view', 'id' => $i, 'name' => $file]) ?>"><span class="glyphicon glyphicon-eye-open"></span></a></p>
                <hr>
                <?php endforeach; ?>

        </div>
    </div>

</div>

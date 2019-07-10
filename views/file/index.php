<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $files app\models\File[] */

$this->title = 'Files';
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
                <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6">

            <?php if (!$files): ?>
                <p>Нет загруженных файлов</p>
            <?php endif; ?>

            <?php foreach ($files as $file): ?>
                <div>
                    id:<?= $file->id ?>  <?= $file->name ?>
                    <?php if ($file->status): ?>
                        <a href="<?= Url::to(['file/view', 'id' => $file->id]) ?>">  <span class="glyphicon glyphicon-eye-open"></span></a>
                        <span class="label label-success">Данные корректны</span>
                    <?php else: ?>
                        <span class="label label-danger">Данные некорректны</span>
                    <?php endif; ?>
                    <a href="<?= Url::to(['file/delete', 'id' => $file->id]) ?>">  <span class="glyphicon glyphicon-remove"></span></a>

                </div>
                <hr>
            <?php endforeach; ?>

        </div>
    </div>

</div>

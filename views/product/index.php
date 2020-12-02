<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $saleForm \app\models\forms\SaleForm */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name',
            'price',
            [
                'attribute' => 'price',
                'value'=> function($data) {

                    /** @var $data app\models\Product */
                    if ($data->color->percent) {
                        return $data->color->percent->value;
                    }
                    return 0;
                },
                'label' => 'Процент'
            ],
            [
                'attribute' => 'price',
                'value'=> function($data) {
                    /** @var $data app\models\Product */
                    if ($data->color->percent) {
                        $percent = ($data->price * $data->color->percent->value) / 100;
                        return $data->price + $percent ;
                    }
                    return $data->price;
                },
                'label' => 'Новая цена'
            ],
            'color_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


<div class="row">
    <div class="col-md-6">

        <div class="product-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($saleForm, 'percent')->textInput(['type' => 'number']) ?>

            <?= $form->field($saleForm, 'color')->dropDownList($saleForm->getListColors(), ['prompt' => 'цвет']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>


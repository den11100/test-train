<?php

namespace app\models\forms;

use app\models\Color;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class SaleForm
 * @package app\models\forms
 */
class SaleForm extends Model
{
    public $percent;
    public $color;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percent', 'color'], 'required'],
            [['percent', 'color'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'percent' => 'Скидка',
            'color' => 'Цвет',
        ];
    }

    /**
     * @return array
     */
    public function getListColors()
    {
         $models = Color::find()->asArray()->all();
         return ArrayHelper::map($models, 'id', 'name');
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "percent".
 *
 * @property int $color_id
 * @property int $value
 *
 * @property Color $color
 */
class Percent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'percent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'color_id' => 'Color ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * Добавляем или обновляем процент
     * @param forms\SaleForm $saleForm
     * @return bool
     */
    public static function addPercent(forms\SaleForm $saleForm)
    {
        $model = self::findOne(['color_id' => $saleForm->color]);

        if ($model) {
            $model->value = $saleForm->percent;
        } else {
            $model = new self();
            $model->color_id = $saleForm->color;
            $model->value = $saleForm->percent;
        }

        return $model->save();
    }


}

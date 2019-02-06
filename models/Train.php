<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "train".
 *
 * @property int $id
 * @property string $station_start
 * @property string $time_start
 * @property string $station_finish
 * @property string $time_finish
 * @property int $travel_time
 * @property int $price
 * @property string $company
 * @property string $schedule
 */
class Train extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'train';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['station_start', 'time_start', 'station_finish', 'time_finish', 'travel_time', 'price', 'company', 'schedule'], 'required'],
            [['time_start', 'time_finish'], 'safe'],
            [['travel_time', 'price'], 'integer'],
            [['station_start', 'station_finish', 'company', 'schedule'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_start' => 'Station Start',
            'time_start' => 'Time Start',
            'station_finish' => 'Station Finish',
            'time_finish' => 'Time Finish',
            'travel_time' => 'Travel Time',
            'price' => 'Price',
            'company' => 'Company',
            'schedule' => 'Schedule',
        ];
    }
}

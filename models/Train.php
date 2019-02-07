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
            [['station_start', 'time_start', 'station_finish', 'time_finish', 'price', 'company', 'schedule'], 'required'],
            [['time_start', 'time_finish'], 'safe'],
            [['travel_time', 'price'], 'integer'],
            [['station_start', 'station_finish', 'company'], 'string', 'max' => 255],
            ['schedule','checkIsArray'],
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

    public function checkIsArray(){
        if(!is_array($this->schedule)){
            $this->addError('schedule','schedule is not array!');
        }
    }

    /**
     * @return array
     */
    public function getDayLabels()
    {
        return [
            "Пн" => "Пн",
            "Вт" => "Вт",
            "Ср" => "Ср",
            "Чт" => "Чт",
            "Пт" => "Пт",
            "Сб" => "Сб",
            "Вс" => "Вс",
        ];
    }

    /**
     * Prepared data in schedule
     */
    public function preparedSchedule()
    {
        if (is_array($this->schedule)) {
            $this->schedule = implode(",", $this->schedule);
        } else {
            $this->schedule = explode(",", $this->schedule);
        }
    }

    /**
     * @return string
     */
    public function dayLabel()
    {
        $this->preparedSchedule();
        return implode(",", $this->schedule);
    }

    /**
     * Add travel time
     */
    public function getTravelTime()
    {
        $this->travel_time = abs(strtotime($this->time_finish) - strtotime($this->time_start));
    }

    public function timeInHoursAndMinutes()
    {
        $hour = floor($this->travel_time/3600);
        $sec = $this->travel_time - ($hour*3600);
        $min = floor($sec/60);
        $sec = $sec - ($min*60);

        return $hour."h ".$min."min ".$sec . "sec";
    }

}

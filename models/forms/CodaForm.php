<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * @property string $url
 * @property string $period_range
 * @property string $table_name
 */
class CodaForm extends Model
{
    public $url;
    public $period_range;
    public $table_name;

    //date_preset
    //today, yesterday, this_month, last_month, this_quarter, lifetime, last_3d, last_7d, last_14d, last_28d, last_30d, last_90d, last_week_mon_sun, last_week_sun_sat, last_quarter, last_year, this_week_mon_today, this_week_sun_today, this_year
    //https://developers.facebook.com/docs/marketing-api/reference/ad-account/adsets

    const PERIOD_YESTERDAY = 'yesterday';
    const PERIOD_THIS_MONTH = 'this_month';
    const PERIOD_LAST_MONTH = 'last_month';
    const PERIOD_LAST_7D = 'last_7d';
    const PERIOD_LAST_30D = 'last_30d';


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'period_range', 'table_name'], 'required'],
            [['url'],'url', 'defaultScheme' => 'https'],
            [['table_name','period_range'],'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'url' => 'Url листа сoda',
            'period_range' => 'Данные за период',
            'table_name' => 'Имя таблицы в coda',
        ];
    }

    public function getListPeriods()
    {
        return [
            self::PERIOD_YESTERDAY => self::PERIOD_YESTERDAY,
            self::PERIOD_LAST_7D => self::PERIOD_LAST_7D,
            self::PERIOD_LAST_30D => self::PERIOD_LAST_30D,
            self::PERIOD_THIS_MONTH => self::PERIOD_THIS_MONTH,
            self::PERIOD_LAST_MONTH => self::PERIOD_LAST_MONTH,
        ];
    }
}

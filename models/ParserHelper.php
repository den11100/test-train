<?php


namespace app\models;


use Yii;
use yii\base\Model;

class ParserHelper extends Model
{
    public static function getUnixTimestamp($datetime)
    {
        $datetime = str_replace('.', '/', $datetime);
        Yii::$app->setTimeZone('UTC');
        $datetime = Yii::$app->formatter->asDatetime($datetime,'php:m/d/Y H:i:s');
        return strtotime($datetime) * 1000;
    }
}
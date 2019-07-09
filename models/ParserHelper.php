<?php


namespace app\models;


use Yii;
use yii\base\Model;

class ParserHelper extends Model
{
    public static function getUnixTimestamp($datetime)
    {
        $datetime = str_replace('.', '/', $datetime);
        $datetime = Yii::$app->formatter->asDatetime($datetime,'MM/d/y H:i:s');
        return strtotime($datetime) * 1000;
    }
}
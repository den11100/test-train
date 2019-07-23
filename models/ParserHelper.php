<?php


namespace app\models;


use phpQuery;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class ParserHelper extends Model
{
    /**
     * @param $name
     * @return array|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function parse($name)
    {
        $file = FileHelper::findFiles(Yii::getAlias('@app').'/uploads',['only'=>[$name]]);

        if ($file) {
            $filePath = array_shift($file);
            $doc = phpQuery::newDocumentHTML(file_get_contents($filePath));

            $arTr = pq($doc)->find('tr:gt(2)');

            $dateTimeList = [];
            $amountList = [];
            foreach ($arTr as $key => $tr) {
                $trPq = pq($tr);

                if (($trPq->find('td:eq(2)')->text()) == 'balance') {
                    $balance = $trPq->find('td:last')->text();
                    $balance = str_replace(' ', '', $balance);
                    $balance = round($balance,2);

                    $amountList[] = end($amountList) + $balance;
                    $dateTimeList[] = self::getUnixTimestamp($trPq->find('td:eq(1)')->text());
                }

                if (($trPq->find('td:eq(2)')->text() == 'buy') || ($trPq->find('td:eq(2)')->text() == 'sell')) {
                    $amount = $trPq->find('td:last')->text();
                    $amount = str_replace(' ', '', $amount);
                    $amount = round($amount,2);

                    $amountList[] = end($amountList) + $amount;
                    $dateTimeList[] = self::getUnixTimestamp($trPq->find('td:eq(1)')->text());
                }
            }

            $seriesData = [];
            foreach ($dateTimeList as $key => $date) {
                foreach ($amountList as $k => $amount) {
                    if ($key == $k) {
                        $seriesData[$key] = [$date, $amount];
                    }
                }
            }

            if ($seriesData) {
                return $seriesData;
            }
        }
        return null;
    }

    /**
     * @param string $datetime
     * @return float|int
     * @throws \yii\base\InvalidConfigException
     */
    public static function getUnixTimestamp($datetime)
    {
        $datetime = str_replace('.', '/', $datetime);
        Yii::$app->setTimeZone('UTC');
        $datetime = Yii::$app->formatter->asDatetime($datetime,'php:m/d/Y H:i:s');
        return strtotime($datetime) * 1000;
    }
}
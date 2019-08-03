<?php

namespace app\models;

use CodaPHP\CodaPHP;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class Coda extends Model
{
    /**
     * @param CodaPHP $coda
     * @param string $docId
     * @param string $tableId
     * @return array
     */
    public static function getCodaRows(CodaPHP $coda, $docId, $tableId)
    {
        $listRows = $coda->listRows($docId, $tableId);

        $rows = [];
        foreach ($listRows['items'] as $row) {
            $rows[] = [
                'Номер аккаунта' => $row['values']['Номер аккаунта'],
                'Статус аккаунта' => $row['values']['Статус аккаунта'],
                'Login' => $row['values']['Login'],
                'Password' => $row['values']['Password'],
                //'Cookie' => $row['values']['Cookie'],
                'Тип аккаунта' => $row['values']['Тип аккаунта'],
                //'Фармер' => $row['values']['Фармер'],
                'Номер' => $row['values']['Номер'],
                'Получить карту' => $row['values']['Получить карту'],
                'Номер карты' => $row['values']['Номер карты'],
                'Инвайт ссылка' => $row['values']['Инвайт ссылка'],
                'Аккаунт готов' => $row['values']['Аккаунт готов'],
                'Mediabuyer' => $row['values']['Mediabuyer'],
                'Выдать баеру' => $row['values']['Выдать баеру'],
                'Prep status' => $row['values']['Prep status'],
                'Name' => $row['values']['Name'],
                'Дата передачи в работу' => $row['values']['Дата передачи в работу'],
                'Дата бана' => $row['values']['Дата бана'],
                'Кол-во дней в работе' => $row['values']['Кол-во дней в работе'],
                'Дней аренды' => $row['values']['Дней аренды'],
                //'Карта человека' => $row['values']['Карта человека'],
                //'Реферал' => $row['values']['Реферал'],
                //'Контакт для связи' => $row['values']['Контакт для связи'],
                //'Комментарий' => $row['values']['Комментарий'],
                //'id' => $row['values']['id'],
                //'Сколько лет аккаунту' => $row['values']['Сколько лет аккаунту'],
                //'Date' => $row['values']['Date'],
                //'Time' => $row['values']['Time'],
                //'Коммент' => $row['values']['Коммент'],
                //'Status' => $row['values']['Status'],
            ];
        }
        return $rows;
    }

    /**
     * @param array $baseTableRows
     * @param array $copyTableRows
     * @param string $keyColumnName
     * @return array
     */
    public static function getNewRows(array $baseTableRows, array $copyTableRows, $keyColumnName)
    {
        $rowNamesBaseTable = ArrayHelper::getColumn($baseTableRows, $keyColumnName);
        $rowNamesCopyTable = ArrayHelper::getColumn($copyTableRows, $keyColumnName);

        $addRows = array_diff($rowNamesBaseTable, $rowNamesCopyTable);

        $result = [];
        foreach ($baseTableRows as $row) {
            if (in_array($row[$keyColumnName], $addRows)) $result[] = $row;
        }
        return $result;
    }

    /**
     * @param array $baseTableRows
     * @param array $copyTableRows
     * @param string $keyColumnName
     * @return array
     */
    public static function getRemoveRows(array $baseTableRows, array $copyTableRows, $keyColumnName)
    {
        $rowNamesBaseTable = ArrayHelper::getColumn($baseTableRows, $keyColumnName);
        $rowNamesCopyTable = ArrayHelper::getColumn($copyTableRows, $keyColumnName);

        return array_diff($rowNamesCopyTable, $rowNamesBaseTable);
    }

    /**
     * @param array $baseTableRows
     * @param array $copyTableRows
     * @param string $keyColumnName
     * @return array
     */
    public static function getUpdateRows(array $baseTableRows, array $copyTableRows, $keyColumnName)
    {
        $preparedBase = ArrayHelper::index($baseTableRows, $keyColumnName);
        $preparedCopy = ArrayHelper::index($copyTableRows, $keyColumnName);

        $diff = array_diff(array_map('json_encode', $preparedBase), array_map('json_encode', $preparedCopy));
        $result = array_map('json_decode', $diff);

        return ArrayHelper::toArray($result);
    }
}
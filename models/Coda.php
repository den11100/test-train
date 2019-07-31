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
                'Логин' => $row['values']['Логин'],
                'Пароль' => $row['values']['Пароль'],
                'Тип аккаунта' => $row['values']['Тип аккаунта'],
                'Номер' => $row['values']['Номер']
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
        //VarDumper::dump($preparedBase,7,1);die;
        $preparedCopy = ArrayHelper::index($copyTableRows, $keyColumnName);

        $diff = array_diff(array_map('json_encode', $preparedBase), array_map('json_encode', $preparedCopy));
        $result = array_map('json_decode', $diff);

        return ArrayHelper::toArray($result);
    }
}
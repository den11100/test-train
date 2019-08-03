<?php

namespace app\commands;

use app\models\Coda;
use CodaPHP\CodaPHP;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CodaController extends Controller
{
    public function actionSyncBase()
    {
        $coda = new CodaPHP("4335b59e-cb34-4106-a55d-f662a8136f2f");

//        Тестовые таблички
//        $baseDocId = 'Xw3SUMXees'; //CRM
//        $baseTableId = 'grid-av2Ob-DeZY'; // ALL ACCOUNTS
//
//        $copyDocId = 'x-qvr7i6pe';
//        $copyTableId = 'grid-av2Ob-DeZY';

        $baseDocId = 'IuphEtBZK-'; //CRM
        $baseTableId = 'grid-av2Ob-DeZY'; // ALL ACCOUNTS

        $copyDocId = 'urMwfrPg41';
        $copyTableId = 'grid-SNr6xSvODJ';


        $keyColumnName = 'Номер аккаунта'; // Название столбца ключа в таблице Coda

        $baseTableRows = Coda::getCodaRows($coda, $baseDocId, $baseTableId);
        $copyTableRows = Coda::getCodaRows($coda, $copyDocId, $copyTableId);

        $newRows = Coda::getNewRows($baseTableRows, $copyTableRows, $keyColumnName);
        if ($newRows) $coda->insertRows($copyDocId, $copyTableId, $newRows, [$keyColumnName]);

        $listRemoveRowName = Coda::getRemoveRows($baseTableRows, $copyTableRows, $keyColumnName);
        if ($listRemoveRowName) {
            foreach ($listRemoveRowName as $rowName) {
                $coda->deleteRow($copyDocId, $copyTableId, $rowName);
            }
        }

        $updateRows = Coda::getUpdateRows($baseTableRows, $copyTableRows, $keyColumnName);
        if ($updateRows) {
            foreach ($updateRows as $key => $row) {
                $coda->updateRow($copyDocId, $copyTableId, $key, $row);
            }
        }

        return ExitCode::OK;
    }
}

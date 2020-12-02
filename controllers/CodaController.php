<?php


namespace app\controllers;

use app\models\Coda;
use Yii;
use app\models\forms\CodaForm;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\httpclient\Client;
use CodaPHP\CodaPHP;


class CodaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'sync-status' => ['get'],
                ],
            ],
        ];
    }

    public function actionStart()
    {
        $model = new CodaForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $dataFacebook = $this->grabFacebook($model->period_range);

            if (!$dataFacebook) {
                Yii::$app->session->setFlash('danger', 'Нет данных на facebook');
                return $this->refresh();
            }

            if ($this->codaInsert($model, $dataFacebook)) {
                Yii::$app->session->setFlash('success', 'Данные в coda обновлены');
                return $this->refresh();
            }
        }

        return $this->render('start', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $period
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    private function grabFacebook($period)
    {
        $data = [
            'access_token' => Yii::$app->params['fb-user-token'],
            'fields' => 'name,account_status,currency,account_id'
        ];

        $accounts = $this->createFbRequest($data, 'me/adaccounts');
        $accounts = $accounts->data['data'];

        $data = [
            'access_token' => Yii::$app->params['fb-user-token'],
            'date_preset' => $period,
            'level' =>'account',
            'fields' =>'spend,account_id',
        ];

        foreach ($accounts as $key => $account) {
            $response = $this->createFbRequest($data, "{$account['id']}/insights");
            if ($response->getData()['data']) {
                $accounts[$key]['spend'] = $response->getData()['data'][0]['spend'];
            } else {
                $accounts[$key]['spend'] = "0";
            }
        }

        return $accounts;
    }

    /**
     * @param array $data
     * @param string $path
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    private function createFbRequest($data, $path)
    {
        $client = new Client();
        return $response = $client->createRequest()
            ->addHeaders(['content-type' => 'application/json'])
            ->setMethod('GET')
            ->setUrl("https://graph.facebook.com/v3.3/$path")
            ->setData($data)
            ->send();
    }

    private function codaInsert(CodaForm $model, Array $dataFacebook)
    {
        $coda = new CodaPHP(Yii::$app->params['coda-api-token']);

        $docId = $coda->getDocId($model->url);
        $tableName = $model->table_name;

        $row = [];
        foreach ($dataFacebook as $data) {
            $row[] = [
                'Account' => $data['name'],
                'API Token' => '',
                'ACC ID' => $data['account_id'],
                'Status' => $this->getLabelStatus($data['account_status']),
                'Cost' => $data['spend'],
                'Date and time' => date("d/m/Y H:i:s")
            ];
        }

        if ($coda->insertRows($docId, $tableName, $row)) {
            return true;
        }
    }

    private function getLabelStatus($key)
    {
        $listFbAccountStatus = [1 => 'ACTIVE', 2=> 'DISABLED', 3 => 'UNSETTLED'];
        return ArrayHelper::getValue($listFbAccountStatus,$key);
    }

    public function actionSyncStatus($key, $row_name, $status)
    {
        $this->checkCkey($key);

        $coda = new CodaPHP(Yii::$app->params['coda-api-token']);
        // Тестовые таблички
//        $baseDocId = 'Xw3SUMXees'; //CRM
//        $baseTableId = 'grid-av2Ob-DeZY'; // ALL ACCOUNTS


        $baseDocId = 'IuphEtBZK-'; //CRM
        $baseTableId = 'grid-av2Ob-DeZY'; // ALL ACCOUNTS

        $status = str_replace('_', ' ', $status);

        $row = ['Статус аккаунта' => $status];
        $coda->updateRow($baseDocId, $baseTableId, $row_name, $row);

        var_dump($row_name);
        var_dump($status);
        echo 'finish';
    }

    private function checkCkey($key)
    {
        if ($key == Yii::$app->params['security-key']) {
            return true;
        }
        die('access-denied');
    }

    public function actionTest()
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

        $columns = $coda->listColumns($copyDocId, $copyTableId);
        $columns = ArrayHelper::getColumn($columns['items'], 'name');
        $listColumns = array_combine($columns, $columns);
        VarDumper::dump($listColumns,7,1);die;

        //$baseTableRows = Coda::getCodaRows($coda, $baseDocId, $baseTableId);
        $copyTableRows = Coda::getCodaRows($coda, $copyDocId, $copyTableId);

        $newRows = Coda::getNewRows($baseTableRows, $copyTableRows, $keyColumnName);
        if ($newRows) $coda->insertRows($copyDocId, $copyTableId, $newRows, [$keyColumnName]);

        $listRemoveRowName = Coda::getRemoveRows($baseTableRows, $copyTableRows, $keyColumnName);
        if ($listRemoveRowName) {
            foreach ($listRemoveRowName as $rowName) {
                $coda->deleteRow($copyDocId, $copyTableId, $rowName);
            }
        }

//        $updateRows = Coda::getUpdateRows($baseTableRows, $copyTableRows, $keyColumnName);
//        if ($updateRows) {
//            foreach ($updateRows as $key => $row) {
//                $coda->updateRow($copyDocId, $copyTableId, $key, $row);
//            }
//        }

        return ExitCode::OK;
    }
}

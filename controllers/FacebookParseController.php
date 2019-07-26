<?php


namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\httpclient\Client;
use CodaPHP\CodaPHP;


class FacebookParseController extends Controller
{
    public function actionStartCoda()
    {
        $coda = new CodaPHP(Yii::$app->params['coda-api-token']);

        // List all your docs
        $result = $coda->listDocs();
        VarDumper::dump($result,7,1);
    }

    public function actionGetAcc()
    {
        $data = [
            'access_token' => Yii::$app->params['fb-user-token'],
            'fields' => 'name,account_status,currency,account_id'
        ];

        $accounts = $this->createFbRequest($data, 'me/adaccounts');
        $accounts = $accounts->data['data'];

        $data = [
            'access_token' => Yii::$app->params['fb-user-token'],
            'date_preset'=>'last_7d', //yesterday
            'level'=>'account',
            'fields'=>'spend,account_id',
        ];

        $listAccountSpendEdge = [];
        foreach ($accounts as $key => $account) {
            $response = $this->createFbRequest($data, "{$account['id']}/insights");
            if ($response->getData()['data']) {
                $accounts[$key]['spend'] = $response->getData()['data'][0]['spend'];
            } else {
                $accounts[$key]['spend'] = "0";
            }
        }

        VarDumper::dump($accounts,7,1);die;
    }

    public function createFbRequest($data, $path)
    {
        $client = new Client();
        return $response = $client->createRequest()
            ->addHeaders(['content-type' => 'application/json'])
            ->setMethod('GET')
            ->setUrl("https://graph.facebook.com/v3.3/$path")
            ->setData($data)
            ->send();
    }
}

//me/adaccounts?fields=name,account_status,currency,balance,id,account_id,amount_spent,insights{ad_name,spend}&limit=1
//?time_range[since]=2019-07-24&time_range[until]=2019-07-25
//me/adaccounts?fields=name,account_status,currency,balance,id,account_id,amount_spent,insights&time_range={'since':'2019-07-23','until':'2019-07-25'}

//act_648962718905301/insights?date_preset=last_7d&level=account&fields=spend,account_id

//[
//    0 => [
//        'name' => '4'
//        'account_status' => 2
//        'currency' => 'USD'
//        'account_id' => '647309095743906'
//        'id' => 'act_647309095743906'
//        'spend' => '76.92'
//    ]
//    1 => [
//        'name' => 'HR_09_USD'
//        'account_status' => 2
//        'currency' => 'USD'
//        'account_id' => '648962718905301'
//        'id' => 'act_648962718905301'
//        'spend' => '0'
//    ]
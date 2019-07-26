<?php


namespace app\controllers;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use FacebookAds\Api;
use FacebookAds\Object\AdAccount;
use Yii;
use yii\base\UserException;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\httpclient\Client;


class FacebookParseController extends Controller
{
    public function actionIndex()
    {
        $fb = new Facebook( [
            'app_id'                => Yii::$app->params['fb-app-id'],
            'app_secret'            => Yii::$app->params['fb-secret'],
            'default_graph_version' => Yii::$app->params['fb-default_graph_version'],
        ]);

        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
                '/me/adaccounts/?fields=account_status,amount_spent,balance,currency,account_id',
                'EAAEwWHznIRQBAGc2QHd5VXYL4LZBv5l787Qb4X2bAZCRbjccPZAtftJw8r1guLn76WYyvBZBugQtPOXF53zFV8T2PjgYphuwF1v7CeKAqhZAdZB5OsQ7OGsRdcVAI7lzVABcaecJVeUyM6OYmPWbOsj6ba1bzyEnj3dckXZAZB9F9nvFW9ihUZB4S3rnzJVsrmrZCnhsw9nh6eaAZDZD'

                //Yii::$app->params['fb-user-token']
            );
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $result = $response->getGraphEdge()->asArray();


//        Api::init(Yii::$app->params['fb-app-id'], Yii::$app->params['fb-secret'], Yii::$app->params['fb-default_graph_version']);
//        $api = Api::instance();
//        //Get HLG Ad Spend
//        $account = new AdAccount('act_753397985117147');
//
//        $params = array(
//            'level' => 'account',
//            'date_preset' => 'yesterday',
//            'fields' => ['spend', 'account_id']
//
//        );
//
//        $insights = $account->getInsights(array(), $params);
//
//        $hlgData = $insights->getResponse()->getContent()['data'];
//        if(isset($hlgData[0]))
//        {
//            $hlgSpendFB = $hlgData[0]['spend'];
//        }else{
//            $hlgSpendFB = "0";
//        }
//        VarDumper::dump($hlgSpendFB,7,1);
    }

    public function actionGetAcc()
    {
        $data = [
            'access_token' => Yii::$app->params['fb-user-token'],
            'fields' => 'account_status,amount_spent,balance,currency,account_id'
        ];

        $response = $this->createFbRequest($data, 'adaccounts');
        VarDumper::dump($response->data,7,1);
    }

    public function createFbRequest($data, $path)
    {
        $client = new Client();
        return $response = $client->createRequest()
            ->addHeaders(['content-type' => 'application/json'])
            ->setMethod('GET')
            ->setUrl("https://graph.facebook.com/v3.3/me/$path")
            ->setData($data)
            ->send();
    }
}

//me/adaccounts?fields=name,account_status,currency,balance,id,account_id,amount_spent,insights{ad_name,spend}&limit=1
//?time_range[since]=2019-07-24&time_range[until]=2019-07-25
//me/adaccounts?fields=name,account_status,currency,balance,id,account_id,amount_spent,insights&time_range={'since':'2019-07-23','until':'2019-07-25'}
//  "id": "act_647309095743906",
//      "account_id": "647309095743906",
// "id": "act_648962718905301",
//      "account_id": "648962718905301",
//      "id": "act_897058800631582",
//      "account_id": "897058800631582",
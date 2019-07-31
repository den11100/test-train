Создать в папке config 2 файла

db.local.php

    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=nameDB',
        'username' => '',
        'password' => '',
        'charset' => 'utf8',
    ]

params_local.php

    return [
        
    ];
    
 
 Cron синхронизация основной таблицы с копией (основная главная)  
 */1 * * * * php /home/u4210/domains/train.sitespro.ru/yii coda/sync-base
  
   
    
    
Возможный вариант испорльзования fb

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
                Yii::$app->params['fb-user-token']
            );
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $result = $response->getGraphEdge()->asArray();   
    }
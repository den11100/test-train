<?php


namespace app\controllers;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Yii;
use yii\base\UserException;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;


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
                '/me/adaccounts',
                'EAAEwWHznIRQBANdNrMtZA69kckKZCcH6oeKbPcs0MDeph8dvjPJzVNDmwDSgzpx42bpt8oC3YUdtMcmwT4LwZAfPoBB4KoRQcugYL6LzXTDBcGRPLJMyFikR2p08rtmgrBYkGBeexsJ8ft7B4v8WXTXqORZCeQC8eioj3H8ahsGTHvQa5JVERmDv38BKDHSTsjWvmwEV7QZDZD'
                //Yii::$app->params['fb-user-token']
            );
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();

        VarDumper::dump($graphNode,7,1);

    }

    public function actionFbToken() {

        $fb = new Facebook( [
            'app_id'                => APP_ID,
            'app_secret'            => APP_SECRET,
            'default_graph_version' => 'v2.4',
        ]);;

        $helper = $fb->getRedirectLoginHelper();

        // Коллбэк от ФВ
        if(\Yii::$app->request->get('code')) {
            try {

                if(!$accessToken = $helper->getAccessToken()) throw new UserException("No access token");

                $oAuth2Client = $fb->getOAuth2Client();
                $tokenMetadata = $oAuth2Client->debugToken( $accessToken );
                $tokenMetadata->validateAppId(APP_ID);
                $tokenMetadata->validateExpiration();
                if (!$accessToken->isLongLived())
                    $accessToken = $oAuth2Client->getLongLivedAccessToken( $accessToken );

                // В мессадже чистый токен
                $message = $accessToken->getValue();

            } catch (FacebookResponseException $e ) {
                $message = 'Graph returned an error: ' . $e->getMessage();
            } catch (FacebookSDKException $e ) {
                $message = 'Facebook SDK returned an error: ' . $e->getMessage();
            } catch (UserException $e) {
                $message = "UserException ".$e->getMessage();
            }

            echo $message;

        } else {
            // Запрос токена
            $login_url = $helper->getLoginUrl(Url::to('azzrael/fb-token', 1), [
                'user_managed_groups', // !!! крайне важное разрешение чтобы публиковать в свои группы
                'publish_actions',
                'manage_pages',
                'publish_pages'
            ]);

            // Редиректим на ФБ, который возвращается сюдаже
            return $this->redirect($login_url);
        }
    }
}
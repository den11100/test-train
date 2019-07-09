<?php


namespace app\controllers;


use app\models\File;
use app\models\ParserHelper;
use phpQuery;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

class FileController extends Controller
{
    public function actionIndex()
    {
        $model = new File();

        $files = FileHelper::findFiles(Yii::getAlias('@app').'/uploads',['only'=>['*.html']]);
        $files = File::getFileName($files);

        if (Yii::$app->request->isPost) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            if ($model->upload()) {
                $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'files' => $files
        ]);
    }

    public function actionView($id, $name)
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
                    $dateTimeList[] = ParserHelper::getUnixTimestamp($trPq->find('td:eq(1)')->text());
                }

                if (($trPq->find('td:eq(2)')->text() == 'buy') || ($trPq->find('td:eq(2)')->text() == 'sell')) {
                    $amount = $trPq->find('td:last')->text();
                    $amount = str_replace(' ', '', $amount);
                    $amount = round($amount,2);

                    $amountList[] = end($amountList) + $amount;
                    $dateTimeList[] = ParserHelper::getUnixTimestamp($trPq->find('td:eq(1)')->text());
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
        }

        return $this->render('view', [
            'seriesData' => $seriesData
        ]);
    }
}
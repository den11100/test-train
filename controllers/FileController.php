<?php


namespace app\controllers;


use app\models\File;
use app\models\ParserHelper;
use phpQuery;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;
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


    //<html>
    //    <body>
    //        <p>Курсы валют</p>
    //        <table>
    //            <tr><td>Валюта</td><td>Курс</td></tr>
    //            <tr><td>EUR</td><td>40</td></tr>
    //            <tr><td>USD</td><td>30</td></tr>
    //            <tr><td>UAN</td><td>20</td></tr>
    //        </table>
    //    </body>
    //</html>
    //Решение:
    //
    //
    //include $_SERVER['DOCUMENT_ROOT'].'phpQuery.php';
    //$pageText = file_get_contents($path);
    ////Создаем корневой объект phpQuery
    ////$document = phpQuery::newDocumentHTML($pageText,'UTF8');//С указание кодировки
    //$document = phpQuery::newDocumentHTML($pageText); //Без указания кодировки
    //$arTr = pq($document)->find('tr:gt(0)');//Получаем все строки, начиная со второй
    //$res = array();
    //foreach ($arTr as $tr){//цикл по строкам
    //    $currency = pq($tr)->find('td:eq(0)')->html();//берем название валюты
    //                                                  //из первой ячейки
    //    $res[$currency] = pq($tr)->find('td:eq(1)')->html(); //курс из второй
    //}

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
                    $dateTimeList[] = $trPq->find('td:eq(1)')->text();
                }

                if (($trPq->find('td:eq(2)')->text()) == 'buy') {
                    $amount = $trPq->find('td:last')->text();
                    $amount = str_replace(' ', '', $amount);
                    $amount = round($amount,2);

                    $amountList[] = end($amountList) + $amount;
                    $dateTimeList[] = $trPq->find('td:eq(1)')->text();
                }
            }

            $seriesData = [];
            foreach ($dateTimeList as $key => $date) {
                foreach ($amountList as $amount) {
                    $result[$key] = [$date, $amount];
                }
            }

            //VarDumper::dump($result,7,1);
        }

        return $this->render('view', [
            'seriesData' => $seriesData
        ]);
    }

    public static function printArr($element)
    {
        echo "<pre>" . print_r($element,true) . "</pre>";
    }
}
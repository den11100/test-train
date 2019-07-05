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

    public function actionView($id, $name)
    {
        $file = FileHelper::findFiles(Yii::getAlias('@app').'/uploads',['only'=>[$name]]);

        if ($file) {
            $filePath = array_shift($file);
            $doc = phpQuery::newDocumentHTML(file_get_contents($filePath), $charset = 'utf-8');

            $amountList = [];
            foreach ($doc->find('table tr') as $tr) {
                $tr = pq($tr);

                //$tr->find('td:first-child')->attr('colspan')->remove();

                $amount = $tr->find('td:last-child')->text();
                if ($amount == "cancelled") continue;
                if (stristr($amount, "expiration")) continue;

                //if (is_numeric($amount)) {
                    $amountList[] = (float) str_replace(' ', '', $amount);
                //}
            }
            self::printArr(array_sum($amountList));
            self::printArr($amountList);
        }

        return $this->render('view', [

        ]);
    }

    public static function printArr($element)
    {
        echo "<pre>" . print_r($element,true) . "</pre>";
    }
}
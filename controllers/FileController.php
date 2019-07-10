<?php


namespace app\controllers;


use app\models\File;
use app\models\ParserHelper;
use app\models\Train;
use phpQuery;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class FileController extends Controller
{
    public function actionIndex()
    {
        $model = new File();

        //$files = FileHelper::findFiles(Yii::getAlias('@app').'/uploads',['only'=>['*.html']]);
        //$files = File::getFileName($files);
        $files = File::find()->orderBy(['id'=>SORT_DESC])->all();

        if (Yii::$app->request->isPost) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');

            if ($model = $model->upload()) {

                if ($seriesData = ParserHelper::parse($model->name)) {
                    $model->status = true;
                    $model->series_data = serialize($seriesData);
                    $model->save(false);
                }
                $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'files' => $files
        ]);
    }

    public function actionView($id)
    {
        /* @var $model File*/
        $model = $this->findModel($id);

        $seriesData = [];
        if ($model->status) {
            $seriesData = unserialize($model->series_data);
        } else {
            throw new NotFoundHttpException('В файле нет нужных данных');
        }

        return $this->render('view', [
            'seriesData' => $seriesData
        ]);
    }

    public function actionDelete($id)
    {
        /* @var $model File*/
        $model = $this->findModel($id);
        $path = Yii::getAlias('@app').'/uploads/'. $model->name;
        if (file_exists($path)) unlink($path);
        $model->delete();
        return $this->redirect(['/file/index']);
    }

    /**
     * Finds the Train model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
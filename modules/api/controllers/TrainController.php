<?php

namespace app\modules\api\controllers;

use app\models\Train;
use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class TrainController extends Controller
{
    protected function verbs()
    {
        return [
            'index' => ['get'],
            'view' => ['get'],
            'create' => ['post'],
            'update' => ['put', 'post'],
        ];
    }

    /**
     * Lists all Train models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Train::find()->asArray()->all();
        return $models;
    }

    /**
     * @param $id
     * @return Train
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->schedule = $model->dayLabel();
        return $model;
    }

    /**
     * @return Train
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $model = new Train();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->validate()) {

            $model->preparedSchedule();

            $model->getTravelTime();

            $model->save(false);

            return $model;
        }

        return $model;
    }

    /**
     * @param $id
     * @return Train
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->validate()) {

            $model->preparedSchedule();

            $model->getTravelTime();

            $model->save(false);

            return $model;
        }

        return $model;
    }

    /**
     * Finds the Train model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Train the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Train::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
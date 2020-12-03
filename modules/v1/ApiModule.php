<?php

namespace app\modules\v1;

class ApiModule extends \yii\base\Module
{
    /**
    * @inheritdoc
    */
    public $controllerNamespace = 'app\modules\v1\controllers';

    public function init()
    {
        parent::init();
    }
}
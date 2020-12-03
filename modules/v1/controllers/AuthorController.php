<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 03.12.20
 * Time: 9:07
 */

namespace app\modules\v1\controllers;

use app\modules\v1\models\Author;
use yii\rest\ActiveController;

class AuthorController extends ActiveController
{
    public $modelClass = Author::class;
}
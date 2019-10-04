<?php
/**
 * Created by PhpStorm.
 * User: guga
 * Date: 10/3/19
 * Time: 1:17 PM
 */

namespace app\modules\api\controllers;


use yii\rest\ActiveController;
use yii\rest\Controller;

class TestController extends ActiveController
{
    public $modelClass = 'app\modules\api\v1\models\GuestModel';

    public function actionIndex()
    {
        echo "Hello";
    }
}
<?php

namespace app\modules\api\v1;

use Yii;
use yii\web\JsonParser;

class Module extends \app\modules\api\Module
{
    public function init()
    {
        // add CORS filter
        parent::init();
        Yii::$app->user->identityClass = 'modules\api\v1\models\ApiUserIdentity';
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;

        Yii::$app->request->parsers['application/json'] = 'yii\web\JsonParser';
    }
}

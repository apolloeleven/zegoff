<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\v1\models\LoginForm;
use yii\rest\ActiveController;


/**
 * Class GuestController
 *
 * @package app\modules\api\v1\controllers
 */
class GuestController extends ActiveController
{
    public $modelClass = 'app\modules\api\v1\models\GuestModel';


    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'is-logged-in' => ['OPTIONS', 'GET'],
            'login' => ['OPTIONS', 'POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionIsLoggedIn()
    {
        $user = UserHelper::getCurrentUser();
        $data = null;
        if ($user) {
            $data = $user->getData();
        }
        return [
            'success' => boolval($user),
            'data' => $data
        ];
    }

    public function actionLogin()
    {
        $request = \Yii::$app->request;

        $model = new LoginForm();
        if ($model->load($request->post(), '') && $model->login()) {
            return [
                'success' => true,
                'data' => \Yii::$app->user->identity->getData(),
                'accessToken' => \Yii::$app->user->identity->access_token
            ];
        }

        return [
            'success' => false,
            'errors' => $model->errors
        ];
    }


}
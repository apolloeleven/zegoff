<?php

namespace app\controllers;

use app\models\Holiday;
use app\models\search\HolidaySearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class RequestController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_MANAGER],
                        'actions' => ['index', 'view', 'confirm']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $searchModel = new HolidaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $model = $this->findAllModelExceptOwn($id);

//        if ($user->position != User::POSITION_HR && $user->department_id != $model->user->department_id) {
//            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
//        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionConfirm()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $model = $this->findAllModelExceptOwn(Yii::$app->request->post('id'));
        $model->setScenario(Holiday::SCENARIO_CONFIRM);
        $model->status = Yii::$app->request->post('status');
        $model->confirmed_by = Yii::$app->user->identity->id;
        $model->confirmed_at = time();
        $model->validate();

        if (!$model->save()) {
            $model->status = Holiday::STATUS_PENDING;
            return $this->render('view', [
                'model' => $model,
            ]);
        }

        $transaction->commit();

        return $this->redirect(Yii::$app->user->identity->getRequestUrl());
    }

    /**
     * @param $id
     * @return Holiday|null
     * @throws NotFoundHttpException
     */
    protected function findAllModelExceptOwn($id)
    {
        if (($model = Holiday::findOne($id)) !== null && $model->user_id != Yii::$app->user->id) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}

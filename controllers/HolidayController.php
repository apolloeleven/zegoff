<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Holiday;
use app\models\search\HolidaySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HolidayController implements the CRUD actions for Holiday model.
 */
class HolidayController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_USER],
                        'actions' => ['index', 'update', 'view', 'create', 'delete']
                    ],
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMINISTRATOR],
                        'actions' => ['requests', 'request-view', 'confirm']
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
        $queryParams['HolidaySearch'] = Yii::$app->request->get('HolidaySearch');
        $queryParams['HolidaySearch']['user_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Holiday model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $type
     * @return string|\yii\web\Response
     *
     */
    public function actionCreate($type)
    {
        $model = new Holiday(['scenario' => $type]);
        $model->type = $type;
        $model->status = Holiday::STATUS_PENDING;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Holiday model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->scenario = $model->type;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function actionRequests()
    {
        $searchModel = new HolidaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('requests/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRequestView($id)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $model = $this->findAllModelExceptOwn($id);

        if ($user->position != User::POSITION_HR && $user->department_id != $model->user->department_id) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $this->render('requests/view', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionConfirm()
    {
        $model = $this->findAllModelExceptOwn(Yii::$app->request->post('id'));
        $model->setScenario(Holiday::SCENARIO_DEFAULT);
        $model->status = Yii::$app->request->post('status');
        $model->confirmed_by = Yii::$app->user->identity->id;
        $model->confirmed_at = time();

        if (!$model->save()) {
            return $this->redirect(['request-view', 'id' => $model->id]);
        }

        if (Yii::$app->user->identity->position != User::POSITION_HR) {
            $url = ['requests'];
        } else {
            $url = ['requests', 'HolidaySearch[department]' => Yii::$app->user->identity->department_id];
        }

        return $this->redirect($url);
    }

    /**
     * Finds the Holiday model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Holiday the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Holiday::findOne($id)) !== null && $model->user_id == Yii::$app->user->id) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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

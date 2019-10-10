<?php

namespace app\controllers;

use app\models\Holiday;
use app\models\User;
use edofre\fullcalendar\models\Event;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;


class SiteController extends Controller
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
                        'actions' => ['index', 'events']
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return array
     */
    public function actionEvents()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $events = [];
        $times = Holiday::find()->joinWith('user')
            ->notDeleted()
            ->andWhere(['=', Holiday::tableName() . '.status', Holiday::STATUS_ACCEPTED])
            ->andWhere(['>=', Holiday::tableName() . '.end_date', \Yii::$app->request->get('start')])
            ->andWhere(['<=', Holiday::tableName() . '.start_date', \Yii::$app->request->get('end')])
            ->all();
        foreach ($times AS $time) {
            $event = new Event();
            $event->id = $time->id;
            $event->backgroundColor = 'green';
            $event->borderColor = 'green';
            $event->title = $time->user->userProfile->getFullName();
            $event->start = date('Y-m-d\TH:i:s\Z', strtotime($time->start_date));
            $event->end = date('Y-m-d\TH:i:s\Z', strtotime($time->end_date));
            $events[] = $event;
        }

        return $events;
    }

}

<?php

namespace app\controllers;

use app\models\Holiday;
use app\models\User;
use edofre\fullcalendar\models\Event;
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
                        'actions' => ['index']
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
        $events = [];
        $times = Holiday::find()->joinWith('user')//->andWhere('1 <= datediff( holiday.end, holiday.start)')
        ->andWhere(['=', 'holiday.status', 2])
            ->all();
        foreach ($times AS $time) {
            $Event = new Event();
            $Event->id = $time->id;
            $Event->backgroundColor = 'green';
            $Event->borderColor = 'green';
            $Event->title = $time->user->userProfile->getFullName();
            $Event->start = date('Y-m-d\TH:i:s\Z', strtotime($time->start_date));
            $Event->end = date('Y-m-d\TH:i:s\Z', strtotime($time->end_date));
            $events[] = $Event;
        }

        return $this->render('index', ['events' => $events]);
    }

}

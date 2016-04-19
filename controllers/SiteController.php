<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Notice;
use yii\data\ActiveDataProvider;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => [ 'index'],
                        'allow' => TRUE,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//    public function actionIndex() {
//        if (!\Yii::$app->user->isGuest) {
//            $dataProvider = new ActiveDataProvider([
//                'query' => Notice::find()->orderBy('date desc'),
//                'pagination' => ['pageSize' => 3],
//            ]);
//            return $this->render('index', [
//                        'dataProvider' => $dataProvider,
//            ]);
//        }
//        $model = new LoginForm();
//
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        }
//        return $this->render('login', [
//                    'model' => $model,
//        ]);
//    }

    public function actionIndex() {

        $dataProvider = new ActiveDataProvider([
            //'query' => Notice::find()->orderBy('date desc'),
            //'query' => Notice::find()->where(['user_id' => \app\models\User::])->orderBy('date desc'),
            'query' => Yii::$app->user->identity->getNotices()->orderBy('date desc'),
            'pagination' => ['pageSize' => 3],
        ]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister() {
        $model = new \app\models\User();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('register', [
                    'model' => $model,
        ]);
    }

}

<?php

namespace app\controllers;
use yii\filters\auth\HttpBasicAuth;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Users';

    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' => function ($action) {
                    return new \yii\data\ActiveDataProvider([
                        'query' => $this->modelClass::find(),
                    ]);
                }
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
                    [
                        'class' => \yii\filters\ContentNegotiator::className(),
                        'only' => ['index', 'create', 'error'],
                        'formats' => [
                            'application/json' => \yii\web\Response::FORMAT_JSON,
                        ],
                    ],
                        'authenticator' => [
                            'class' => HttpBasicAuth::className(),
                            'auth'  => function ($username, $password) {
                                return \app\models\Users::findOne([
                                    'username' => $username,
                                    'password' => $password,
                                ]);
                            }
                        ]
                ];
    }

    /**
     * ErrorAction displays application errors using a specified view.
     *
     * @return array
     */
    public function actionError()
    {
        return array('Error' => \Yii::$app->getSecurity()->generateRandomString(12));
    }
}

<?php

namespace app\controllers;
use yii\filters\Cors;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;

class LoginController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Users';
    private $result;

    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' => function ($action) {
                    $result = [
                        'success' => 1,
                        'username' =>  $this->result['username'],
                        'token' => $this->result['token']
                    ];
                    return $result;
                }
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
                        'only' => ['index'],
                        'formats' => [
                            'application/json' => \yii\web\Response::FORMAT_JSON,
                        ],
                    ],
                    'authenticator' => [
                        'class' => CompositeAuth::className(),
                        'authMethods' => [
                            QueryParamAuth::className(),
                        ],
                        'except' => ['index'],
                    ],
                    'corsFilter' => [
                        'class' => Cors::className(),
                        'cors' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                        ],
                    ]
                ];
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        $get = \Yii::$app->request->get();
        if ( array_key_exists( 'username', $get ) && array_key_exists( 'password', $get ) ) {
            $result = $this->modelClass::authentication( $get['username'], $get['password'] );
            if ( $result === null ) {
                throw new \yii\web\UnauthorizedHttpException();
            }
            $this->result = $result;
        }
        else {
            throw new \yii\web\UnauthorizedHttpException();
        }
    }
}

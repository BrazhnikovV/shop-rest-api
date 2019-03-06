<?php

namespace app\controllers;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Users';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                    [
                        'class' => \yii\filters\ContentNegotiator::className(),
                        'only' => ['index', 'view'],
                        'formats' => [
                            'application/json' => \yii\web\Response::FORMAT_JSON,
                        ]
                    ]
                ];
    }

    public function actionUsers()
    {
        $model = new $this->modelClass([
            'username' => $this->username,
        ]);

        $model->load( Yii::$app->getRequest()->getBodyParams(), '' );
        if ( $model->save() ) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode( 201 );
            $id = implode(',', array_values( $model->getPrimaryKey( true ) ) );
            $response->getHeaders()->set( 'Location', Url::toRoute( [$this->viewAction, 'id' => $id], true ) );
        }
        elseif ( !$model->hasErrors() ) {
            throw new ServerErrorHttpException( 'Failed to create the object for unknown reason.' );
        }

        return $model;
    }
}

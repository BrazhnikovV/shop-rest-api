<?php
namespace rest\controllers\crud\controllers;

use common\models\Users;
use yii\rest\Controller;
use common\models\LoginForm;
use common\models\RegistrForm;

/**
 * Class UserController
 * @package rest\controllers
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ]
        ];
    }

    /**
     * This method implemented to demonstrate the receipt of the token.
     * Do not use it on production systems.
     * @return string AuthKey or model with errors
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ( $model->load( \Yii::$app->getRequest()->getBodyParams(), '' ) && $model->login() ) {
            return array (
                'auth_key' => \Yii::$app->user->identity->getAuthKey(),
                'username' => $model->username );
        } else {
            return $model;
        }
    }

    /**
     * This method
     * @return
     */
    public function actionRegister() {

        $model = new RegistrForm();

        if ( $model->load( \Yii::$app->getRequest()->getBodyParams(), '' ) && $model->register() ) {

            $user = $this->createUser( $model );
            if ( $user->save() ) {
                return $user->attributes;
            }
            else {
                return $user->errors;
            }

        } else {
            return $model;
        }
    }

    /**
     * This method
     * @return
     */
    private function createUser( $model ) {
        $user = new Users();
        $user->username = $model->username;
        $user->email    = $model->email;
        $user->status   = $model->status;
        $user->auth_key = bin2hex( random_bytes(16 ) );
        $user->password_hash = password_hash( $model->password, PASSWORD_BCRYPT );

        return $user;
    }
}

<?php
namespace rest\versions\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;

/**
 * Class UsersController
 * @version 1.0.1
 * @package rest\versions\v1\controllers
 */
class UsersController extends ActiveController
{
    /**
     *  @access public
     *  @var $modelClass - класс модели
     */
    public $modelClass = 'common\models\Users';

    /**
     * Добавляем поведения для аутентификации, включения CORS
     * @return array
     */
    public function behaviors() {

        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['options']
        ];

        return $behaviors;
    }

    /**
     * actions controller
     * @return array
     */
    public function actions() {

        return array_merge(
            parent::actions(),
            [
                'index' => [
                    'class' => 'yii\rest\IndexAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'prepareDataProvider' => function ( $action ) {
                        $model = new $this->modelClass;
                        $query = $model::find()->orderBy([ 'id' => SORT_DESC ]);
                        $dataProvider = new ActiveDataProvider(['query' => $query]);

                        return $dataProvider;
                    }
                ],
                'delete' => [
                    'class' => 'yii\rest\DeleteAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                ]
            ]
        );
    }
}

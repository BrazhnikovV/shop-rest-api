<?php
namespace rest\versions\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;

/**
 * Class OrdersController
 * @version 1.0.1
 * @package rest\versions\v1\controllers
 */
class OrdersController extends ActiveController
{
    /**
     *  @access public
     *  @var $modelClass - класс модели
     */
    public $modelClass = 'common\models\Orders';

    /**
     * Добавляем поведения для аутентификации, включения CORS
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        return $behaviors;
    }

    /**
     * actions controller
     * @return array
     */
    public function actions()
    {
        return array_merge(
            parent::actions(),
            [
                'index' => [
                    'class' => 'yii\rest\IndexAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'prepareDataProvider' => function ( $action ) {
                        $model = new $this->modelClass;
                        $query = $model::find()->orderBy([
                            'id' => SORT_DESC
                        ]);
                        $dataProvider = new ActiveDataProvider(['query' => $query]);

                        $model->setAttribute('name', @$_GET['name']);
                        $query->andFilterWhere(['like', 'name', $model->name]);

                        return $dataProvider;
                    }
                ],
                'create' => [
                    'class' => 'yii\rest\CreateAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'scenario' => $this->createScenario,
                ]
            ]
        );
    }
}

<?php
namespace rest\versions\v1\controllers;

use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class ProductsController extends ActiveController
{
    public $modelClass = 'common\models\Products';

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

    public function actions()
    {
        return array_merge(
            parent::actions(),
            [
                'index' => [
                    'class' => 'yii\rest\IndexAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'prepareDataProvider' => function ($action) {
                        /* @var $model Post */
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

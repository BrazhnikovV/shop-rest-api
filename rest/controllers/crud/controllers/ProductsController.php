<?php
namespace rest\controllers\crud\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;

/**
 * Class ProductsController
 * @version 1.0.1
 * @package rest\versions\v1\controllers
 */
class ProductsController extends ActiveController
{
    /**
     *  @access public
     *  @var $modelClass - класс модели
     */
    public $modelClass = 'common\models\Products';

    /**
     * Добавляем поведения для аутентификации, включения CORS
     * @return array
     */
    public function behaviors()
    {
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
                    'class' => 'common\actions\CreateActionWithSaveFiles',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'scenario' => $this->createScenario,
                ],
                'update' => [
                    'class' => 'yii\rest\UpdateAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'scenario' => $this->updateScenario,
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

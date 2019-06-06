<?php
namespace rest\controllers\read\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;

/**
 * CategoriesController
 * @version 1.0.1
 * @package rest\versions\v1\controllers
 */
class CategoriesController extends ActiveController
{
    /**
     *  @access public
     *  @var $modelClass - класс модели
     */
    public $modelClass = 'common\models\Categories';

    /**
     * Добавляем поведения для аутентификации, включения CORS
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
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
                ]
            ]
        );
    }
}

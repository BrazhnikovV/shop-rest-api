<?php
namespace rest\controllers\read\controllers;

use common\models\Categories;
use yii\rest\ActiveController;

/**
 * CategoriesController
 * @version 1.0.1
 * @package rest\controllers\read\controllers
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
     * This method implemented
     */
    public function actionList() {

        $all_categories = array();
        $parent_categories = Categories::find()->where( ['=', 'parent_id', 0] )->all();
        foreach ( $parent_categories as $key => $parent_category ) {

            $children = Categories::find()->where( ['=', 'parent_id', $parent_category->id] )->all();
            foreach ( $children as $key_children => $child ) {

                $all_categories[$key]['children'][$key_children]['category'] = $child;
                $all_categories[$key]['children'][$key_children]['products'] = $child->products;
            }
            $all_categories[$key]['parent']   = $parent_category;
        }

        return $all_categories;
    }

    /**
     * This method implemented
     */
    public function actionNoparrentlist() {
        $model = new $this->modelClass;
        $categories = $model::find()->where( ['!=', 'parent_id', 0] )->all();
        return $categories;
    }
}

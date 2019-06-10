<?php
namespace rest\controllers\read\controllers;

use common\models\Products;
use yii\rest\ActiveController;

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
    public function behaviors() {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    /**
     * This method implemented
     */
    public function actionList() {
        $products = Products::find()->where( ['!=', 'hidden', 0] )->all();
        return $products;
    }
}

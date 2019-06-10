<?php
namespace rest\controllers\read\controllers;

use yii\web\UploadedFile;
use common\models\Products;
use common\models\UploadForm;
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
    public function actionList($id = null) {

        if ( $id === null ) {
            $products = Products::find()->where( ['!=', 'hidden', 0] )->all();
        }
        else {
            $products = Products::find()->where( ['=', 'category_id', $id] )->all();
        }
        return $products;
    }

    /**
     * This method implemented
     */
    public function actionUpload() {

        $model = new UploadForm();

        if ( \Yii::$app->request->isPost ) {
            $model->files = UploadedFile::getInstancesByName( 'files' );

            if ( $model->files && $model->validate() ) {
                $saves = array();
                foreach ( $model->files as $key => $file ) {
                    $filename = $file->getBaseName() . '.' . $file->getExtension();
                    $saves[$filename] = $file->saveAs( 'uploads/' . $filename );
                }
                return $saves;
            }
            else {
                return $model->errors;
            }
        }
    }
}

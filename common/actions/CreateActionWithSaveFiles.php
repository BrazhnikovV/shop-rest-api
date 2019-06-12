<?php

namespace common\actions;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\rest\CreateAction;
use common\models\UploadForm;
use common\models\ProductImages;
use yii\web\ServerErrorHttpException;

class CreateActionWithSaveFiles extends CreateAction
{
    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run() {

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /**
         * @var $model \yii\db\ActiveRecord
         */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        // производим декодирование параметров запроса из json в объект
        // так как запрос посылается с angular - клиента, по средствам
        // formData для обеспечения возможности передачи файлов
        $body_params = Yii::$app->getRequest()->getBodyParam('data' );
        $post_data   = ( array ) json_decode( $body_params );

        $model->load( $post_data, '' );

        if ( $model->save() && $this->saveFiles( $model->id ) ) {

            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        }
        elseif ( !$model->hasErrors() ) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

    /**
     * saveFiles - сохранить файлы на сервере
     * @param $product_id - идентификатор продукта
     * @return array | boolean !!! Есть возможность возвращать массив ошибок
     */
    private function saveFiles( $product_id ) {

        if ( $_FILES ) {

            $errors = array();
            $model  = new UploadForm();

            foreach ( $_FILES as $key => $file ) {
                $inst_file = UploadedFile::getInstanceByName($key);
                array_push($model->files, $inst_file);
            }

            if ( $model->validate() ) {
                foreach ( $model->files as $key => $file ) {
                    $save_result = $this->validateAndSaveFile( $file, $product_id );
                    if ( $save_result !== true ) {
                        $errors[$key] = $this->validateAndSaveFile( $file, $product_id );
                    }
                }
                return !( boolean ) count( $errors );
            }
        }
        else {
            return false;
        }
    }

    /**
     * validateAndSaveFile - проверить и сохранить файл
     * @param $file - объект целевого файла
     * @param $product_id - идентификатор продукта
     * @return array | boolean
     */
    private function validateAndSaveFile( $file, $product_id ) {

        $product_images = new ProductImages();
        $filename = $file->getBaseName() . '.' . $file->getExtension();

        if ( $file->saveAs( 'uploads/' . $filename ) ) {

            $product_images->name = $filename;
            $product_images->product_id = $product_id;
            $product_images->type = $file->type;
            $product_images->size = $file->size;

            if ( $product_images->validate() ) {
                return $product_images->save();
            }
            else {
                return $product_images->errors;
            }
        }
    }
}

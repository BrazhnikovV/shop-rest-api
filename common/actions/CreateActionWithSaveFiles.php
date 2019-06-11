<?php

namespace common\actions;

use Yii;
use yii\helpers\Url;
use yii\rest\CreateAction;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class CreateActionWithSaveFiles extends CreateAction
{
    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        //UploadedFile::getInstancesByName( 'files' );

        echo '<pre>';
        var_dump(Yii::$app->request->post('data'));
        echo '</pre>';
        exit();

        if ($model->save()) {

            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }
}

<?php

namespace common\models;

use yii\base\Model;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string  $name
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $files;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['files'], 'file', 'extensions' => 'png, jpg, svg', 'skipOnEmpty' => false, 'maxFiles' => 10]
        ];
    }
}

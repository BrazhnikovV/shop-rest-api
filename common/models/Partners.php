<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "partners".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $url
 * @property string  $description
 * @property integer $hidden
 * @property integer $created_at
 * @property integer $updated_at
 */
class Partners extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%partners}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'description'], 'required'],
            [['description', 'url', 'name'], 'string'],
            [['hidden'], 'integer'],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'url',
            'description',
            'hidden',
            'created_at' => function () {
                return date('d-m-y H:i', $this->created_at);
            },
            'updated_at' => function () {
                return date('d-m-y H:i', $this->updated_at);
            },
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Name',
            'url'         => 'Url',
            'description' => 'Description',
            'hidden'      => 'hidden',
            'created_at'  => 'created',
            'updated_at'  => 'updated',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {

            }
            return true;
        } else {
            return false;
        }
    }
}

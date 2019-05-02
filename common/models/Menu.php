<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $url
 * @property string  $description
 * @property string  $hidden
 * @property integer $nesting
 * @property integer $created_at
 * @property integer $updated_at
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
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
            [['name', 'url'], 'required'],
            [['name','url'], 'string'],
            [['nesting'], 'integer'],
            [['hidden'], 'in', 'range' => [0, 1]],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 512]
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
            'nesting',
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
            'id'   => 'ID',
            'name' => 'Name',
            'url'  => 'Url',
            'description' => 'Description',
            'hidden' => 'Hidden',
            'nesting' => 'Nesting',
            'created_at' => 'created',
            'updated_at' => 'updated',
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
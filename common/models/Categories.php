<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $description
 * @property string  $hidden
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Categories extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
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
            [['name', 'description'], 'required'],
            [['name', 'description'], 'string'],
            [['parent_id'], 'integer'],
            [['hidden'], 'boolean'],
            [['name'], 'string', 'min' => 4, 'max' => 128],
            [['description'], 'string','min' => 4, 'max' => 512]
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'hidden',
            'parent_id',
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
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'hidden' => 'Hidden',
            'parent_id' => 'Nesting',
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

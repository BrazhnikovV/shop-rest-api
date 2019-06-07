<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string  $name
 * @property string  $description
 * @property integer $price
 * @property string  $code
 * @property integer $hidden
 * @property integer $created_at
 * @property integer $updated_at
 */
class Products extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
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
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasOne( Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'code','category_id'], 'required'],
            [['description','name'], 'string'],
            [['hidden'], 'boolean'],
            [['price','category_id'], 'integer'],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'category_id',
            'name',
            'description',
            'price',
            'code',
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
            'category_id' => 'CategoryID',
            'name'        => 'Name',
            'description' => 'Description',
            'price'       => 'Price',
            'code'        => 'Code',
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

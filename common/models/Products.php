<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $author_id
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'code'], 'required'],
            [['description','name'], 'string'],
            [['price'], 'integer'],
        ];
    }

    public function fields()
    {
        return [
            'id',
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

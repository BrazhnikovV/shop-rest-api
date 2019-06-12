<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_images".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string  $name
 * @property string  $type
 * @property integer $size
 * @property integer $created_at
 */
class ProductImages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_images}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
            [['name','product_id'], 'required'],
            [['type','name'], 'string'],
            [['product_id', 'size'], 'integer'],
            [['updated_at'], 'safe'],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'product_id',
            'name',
            'type',
            'size',
            'created_at' => function () {
                return date('d-m-y H:i', $this->created_at);
            },
            'updated_at' => function () {
                return date('d-m-y H:i', $this->created_at);
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
            'product_id'  => 'ProductID',
            'name'        => 'Name',
            'type'        => 'Type',
            'size'        => 'Size',
            'created_at'  => 'created',
            'updated_at'  => 'updated_at',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave( $insert ) {

        if ( parent::beforeSave( $insert ) ) {
            if ($insert) {

            }
            return true;
        } else {
            return false;
        }
    }
}

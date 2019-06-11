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
 * @property string  $description
 * @property integer $created_at
 * @property integer $updated_at
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
     * @return \yii\db\ActiveQuery
     */
    public function getCategories() {
        return $this->hasOne( Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','product_id'], 'required'],
            [['description','name'], 'string'],
            [['product_id'], 'integer'],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'product_id',
            'name',
            'description',
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
            'product_id'  => 'ProductID',
            'name'        => 'Name',
            'description' => 'Description',
            'created_at'  => 'created',
            'updated_at'  => 'updated',
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

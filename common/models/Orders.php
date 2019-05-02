<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $name
 * @property string  $description
 * @property string  $price
 * @property integer $code
 * @property integer $created_at
 * @property integer $updated_at
 */
class Orders extends ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orders}}';
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
            [
                ['name', 'description'],
                'filter',
                'filter' => function ($value) {
                    return \Yii::$app->formatter->asHtml($value);
                }
            ],
            [['name', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['price'], 'integer'],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_PUBLISHED]],
            [['name'], 'string', 'max' => 128]
        ];
    }

    public function extraFields()
    {
        return [
            'comments',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'description',
            'price',
            'status',
            'author',
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
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'created',
            'updated_at' => 'updated',
            'user_id' => 'User ID',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (empty($this->user_id)) {
                    $this->user_id = \Yii::$app->user->identity->getId();
                }
            }
            return true;
        } else {
            return false;
        }
    }
}

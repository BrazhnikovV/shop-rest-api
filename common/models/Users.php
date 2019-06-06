<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string  $username
 * @property string  $auth_key
 * @property string  $password_hash
 * @property string  $email
 * @property string  $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            [['username', 'auth_key', 'password_hash','email', 'status'], 'required'],
            ['username', 'string', 'length' => [4, 64]],
            ['username', 'unique'],
            ['auth_key', 'string', 'length' => 32],
            ['password_hash', 'string', 'length' => [0, 255]],
            ['email', 'email'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['created_at', 'updated_at', 'password_reset_token'], 'safe']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'email',
            'status',
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
            'id'         => 'ID',
            'username'   => 'Username',
            'email'      => 'Email',
            'status'     => 'Status',
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

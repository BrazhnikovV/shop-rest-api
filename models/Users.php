<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $pass_hash
 * @property string $pass_reset_token
 * @property string $email
 * @property int $status
 * @property int $updated
 * @property int $created
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'pass_hash', 'pass_reset_token', 'email', 'status', 'updated', 'created'], 'required'],
            [['status', 'updated', 'created'], 'integer'],
            [['username'], 'string', 'max' => 64],
            [['auth_key'], 'string', 'max' => 32],
            [['pass_hash', 'pass_reset_token', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'pass_hash' => Yii::t('app', 'Pass Hash'),
            'pass_reset_token' => Yii::t('app', 'Pass Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'updated' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}

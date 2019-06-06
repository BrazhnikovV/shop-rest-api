<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 *  Registr form
 */
class RegistrForm extends Model
{
    public $username;
    public $password;
    public $repeat_password;
    public $email;
    public $status;
    private $_user = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'repeat_password', 'email'], 'required'],
            ['username', 'string', 'length' => [4, 64]],
            ['password', 'string', 'length' => [4, 64]],
            ['repeat_password', 'string', 'length' => [4, 64]],
            ['email', 'email'],
            ['password', 'compare', 'compareAttribute' => 'repeat_password'],
            ['status', 'default', 'value' => 10]
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            return true;
        } else {
            return false;
        }
    }
}

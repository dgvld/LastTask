<?php

namespace app\models;

use yii\base\Model;



class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $code;
    public $active=0;
    public $auth_key;

    public function rules()
    {
        return [
            [[ 'email', 'password'], 'required'],
            [['email'], 'email'],
            [['active'], 'integer'],
            [['email', 'password', 'username','auth_key', 'code'], 'string', 'max' => 255],
            [['auth_key', 'code','active'], 'safe'],
            ['username', 'required'],
            ['username','unique', 'targetClass' => '\app\models\User', 'message' => 'Такое имя уже существует'],
        ];
    }
    /**
     * @return bool
     */

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->setCode($this->code);
            $user->generateAuthKey();
            $user->sendConfirmationLink();
            return $user->create();

        }
    }
}
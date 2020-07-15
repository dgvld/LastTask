<?php

namespace app\models;

use yii\widgets\ActiveForm;
use yii\base\Model;



class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $code;
    public $active=0;
    public $auth_key;
    public $password_repeat;
    public $phone;
    public $date_create;
    public $verifyCode;


    public function rules()
    {
        return [
            [[ 'email', 'password'], 'required'],
            [['active'], 'integer'],
            [['email', 'password', 'username','auth_key', 'code', 'phone'], 'string', 'max' => 255],
            [['auth_key', 'code','active', 'phone', 'date_create'], 'safe'],
            ['username', 'required'],
            ['email','unique', 'targetClass' => '\app\models\User', 'message' => 'Такой Email уже существует'],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают" ],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
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
            $user->phone = $this->phone;
            $user->setPassword($this->password);
            $user->setCode($this->code);
            $user->generateAuthKey();
            $user->sendConfirmationLink();
            $user->date_create = $this->date_create;
            return $user->create();

        }
    }
}
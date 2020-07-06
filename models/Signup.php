<?php

namespace app\models;

use yii\base\Model;

class Signup extends Model
{
    public $fio;
    public $email;
    public $phone;
    public $date_create;
    public $password;

    public function rules()
    {
        return [

            [['fio', 'email','password', 'phone'],'required'],
            ['email','email'],
            ['email','unique','targetClass'=>'app\models\User'],
            [['date_create'], 'safe'],
            ['password','string','min'=>2,'max'=>10],
            [['phone'], 'string', 'max' => 50],
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->fio = $this->fio;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->date_create = $this->date_create;
        $user->setPassword($this->password);
        return $user->save(); //вернет true или false
    }

}
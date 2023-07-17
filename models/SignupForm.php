<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{

 public  $username;
 public  $email;
 public  $password;
 public  $passwordVerify;

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'passwordVerify'], 'required', 'message' => 'Необходимо заполнить поле'],
            [['email'], 'email'],
            ['passwordVerify', 'compare', 'compareAttribute'=>'password', 'message'=> "Пароли не совпадают" ]
        ];
    }

}
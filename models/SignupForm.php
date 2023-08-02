<?php

namespace app\models;

use Yii;
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
            ['username', 'match', 'pattern' => '/^[a-zA-Zа-яеёА-ЯЕЁ]+$/u', 'message' => 'Введены недопустимые символы'],
            [['email'], 'email', 'message' => 'Введите существующий email'],
            [['email'], 'unique', 'targetClass' => User::className(), 'message' => 'Этот email уже зарегистрирован'],
            ['password', 'match', 'pattern' => '/^(?=.*\d)[A-Za-z\d]+$/',
                'message' => 'Пароль должен содержать буквы A-z и минимум 1 цифру.'],
            ['password', 'string', 'min'=>6, 'tooShort' => 'Минимальная длина пароля 6 символов'],
            ['passwordVerify', 'compare', 'compareAttribute'=>'password', 'message'=> "Пароли не совпадают" ]
        ];
    }

}
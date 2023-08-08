<?php

namespace app\models;

use yii\base\Model;

class UpdateForm extends Model
{
    public  $username;
    public  $email;

    public function rules()
    {
        return [
            [['username', 'email'], 'required', 'message' => 'Необходимо заполнить поле'],
            ['username', 'match', 'pattern' => '/^[a-zA-Zа-яеёА-ЯЕЁ]+$/u', 'message' => 'Введены недопустимые символы'],
            [['email'], 'email', 'message' => 'Введите существующий email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя'
        ];
    }
}
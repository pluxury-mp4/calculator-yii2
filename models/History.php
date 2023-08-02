<?php

namespace app\models;

use yii\db\ActiveRecord;

class History extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%history}}';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getSnapshotArray(): array
    {
        return json_decode($this->snapshot, true);
    }

    public function attributeLabels()
    {
        return [
            'month' => 'Месяц',
            'tonnage' => 'Тоннаж',
            'raw_type' => 'Тип сырья',
            'price' => 'Результат',
            'username' => 'Имя',
            'created_at' => 'Дата создания',
        ];
    }
}
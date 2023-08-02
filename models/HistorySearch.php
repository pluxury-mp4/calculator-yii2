<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class HistorySearch extends History
{
    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            [['id', 'tonnage', 'price'], 'integer'],
            [['username', 'raw_type', 'month', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = History::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'raw_type', $this->raw_type])
            ->andFilterWhere(['like', 'tonnage', $this->tonnage])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }

    public function userSearch($params)
    {
        $query = History::find()->where(['user_id' => Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'raw_type', $this->raw_type])
            ->andFilterWhere(['like', 'tonnage', $this->tonnage])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;

    }
}
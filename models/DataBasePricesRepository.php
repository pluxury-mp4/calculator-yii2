<?php

namespace app\models;

use yii\db\Query;
use yii\helpers\ArrayHelper;

class DataBasePricesRepository
{
    public function getMonthsListFromDb()
    {
        $query = (new Query())->select('name')->orderBy('id')->from('months')->all();
        return ArrayHelper::map($query,'name','name');
    }

    public function getRawTypesListFromDb()
    {
        $query = (new Query())->select('name')->orderBy('id')->from('raw_types')->all();
        return ArrayHelper::map($query, 'name', 'name');

    }

    public function getTonnagesListFromDb()
    {
        $query = (new Query())->select(['id', 'value'])->orderBy('id')->from('tonnages')->all();
        return ArrayHelper::map($query, 'value', 'value');
    }

    public function getPriceFromDb(string $raw_type, string $month, int $tonnage)
    {
        return (new Query())->select('price')->from('prices')
            ->innerJoin('raw_types', 'raw_types.id = prices.raw_type_id')
            ->innerJoin('months', 'months.id = prices.month_id')
            ->innerJoin('tonnages', 'tonnages.id = prices.tonnage_id')
            ->where(['raw_types.name' => $raw_type])
            ->andWhere(['months.name' => $month])
            ->andWhere(['tonnages.value' => $tonnage])
            ->scalar();
    }

    public function getPriceArrayFromDb(string $raw_type, string $month)
    {
        return (new Query())->select('price')->from('prices')
            ->innerJoin('raw_types', 'raw_types.id = prices.raw_type_id')
            ->innerJoin('months', 'months.id = prices.month_id')
            ->where(['raw_types.name' => $raw_type])
            ->andWhere(['months.name' => $month])
            ->groupBy(['month_id', 'tonnage_id'])->column();
    }

    public function getAllPrices($raw_type_value)
    {
            $query = (new Query())
                ->select(['tonnages.value','months.name','prices.price'])
                ->from('prices')
                ->innerJoin('tonnages', 'tonnages.id = prices.tonnage_id')
                ->innerJoin('months', 'months.id = prices.month_id')
                ->innerJoin('raw_types', 'raw_types.id = prices.raw_type_id')
                ->where(['raw_types.name' => $raw_type_value])
                ->orderBy(['months.id' => SORT_ASC, 'tonnages.id' => SORT_ASC])
                ->all();

        $QueryArrayForJson = [];
        foreach ($query as $item) {
            $QueryArrayForJson[$item['name']][$item['value']] = $item['price'];
        }

        return $QueryArrayForJson;
    }
}
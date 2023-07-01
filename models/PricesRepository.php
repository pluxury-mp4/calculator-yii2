<?php

namespace app\models;

class PricesRepository
{
    private $prices;

    public function __construct(array $prices)
    {
        $this->prices = $prices;
    }

    public function getPrices(){
        return $this->prices;
    }

    public function getMonthsList()
    {
        return [
            'Январь' => 'Январь',
            'Февраль' => 'Февраль',
            'Август' => 'Август',
            'Сентябрь' => 'Сентябрь',
            'Октябрь' => 'Октябрь',
            'Ноябрь' => 'Ноябрь',
        ];
    }

    public function getTonnagesList()
    {
        return [
            '25' => '25',
            '50' => '50',
            '75' => '75',
            '100' => '100',
        ];
    }

    public function getRawTypesList()
    {
        return [
            'Шрот' => 'Шрот',
            'Жмых' => 'Жмых',
            'Соя' => 'Соя',
        ];
    }

    public function getPrice(string $raw_type, string $month, int $tonnage)
    {
        return $this->prices[$raw_type][$month][$tonnage];
    }

    public function getTonnagesByRawTypeAndMonth(string $raw_type, string $month)
    {
        return array_keys($this->prices[$raw_type][$month]);
    }

    public function getMonthsByRawType(string $raw_type)
    {
        return array_keys($this->prices[$raw_type]);
    }

    public function getPriceByRawTypeAndMonth(string $raw_type, string $month)
    {
        return $this->prices[$raw_type][$month];
    }

}
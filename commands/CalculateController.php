<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\config\Prices;

class CalculateController extends Controller
{
    public function actionIndex($raw_type = "", $month = "", $tonnage = 0)
    {
        $priceObj = new Prices();

        $missingParams = [];

        if (empty($raw_type)) {
            $missingParams[] = "Тип";
        }
        if (empty($month)) {
            $missingParams[] = "Месяц";
        }
        if (empty($tonnage)) {
            $missingParams[] = "Тоннаж";
        }

        if (!empty($missingParams)) {
            echo "Выполнение команды завершено с ошибкой" . PHP_EOL .
                "Необходимо ввести " . implode(", ", $missingParams);
            return ExitCode::DATAERR;
        }

        $incorrectData = [];
        if (!isset($priceObj->price[$raw_type])) {
            $incorrectData[] = "Не найден прайс для значения $raw_type";
        }

        if (!isset($priceObj->price[$raw_type][$month])) {
            $incorrectData[] = "Не найден прайс для значения $month";
        }

        if (!isset($priceObj->price[$raw_type][$month][$tonnage])) {
            $incorrectData[] = "Не найден прайс для значения $tonnage";
        }

        if (!empty($incorrectData)) {
            echo "Выполнение команды завершено с ошибкой" . PHP_EOL .
                implode(PHP_EOL , $incorrectData) . PHP_EOL .
                "проверьте корректность введенных значений";
            return ExitCode::DATAERR;
        }


        echo "ok";
        return ExitCode::OK;


    }
}
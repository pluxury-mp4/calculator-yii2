<?php

namespace app\commands;

use LucidFrame\Console\ConsoleTable;
use yii\console\Controller;
use yii\console\ExitCode;
use app\config\Prices;
use yii\helpers\BaseConsole;
use yii\helpers\Console;

class CalculateController extends Controller
{
    public function actionIndex($raw_type = "", $month = "", $tonnage = 0)
    {

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
        if (!isset(\Yii::$app->params['prices'][$raw_type])) {
            $incorrectData[] = "Не найден прайс для значения $raw_type";
        }

        if (!isset(\Yii::$app->params['prices'][$raw_type][$month])) {
            $incorrectData[] = "Не найден прайс для значения $month";
        }

        if (!isset(\Yii::$app->params['prices'][$raw_type][$month][$tonnage])) {
            $incorrectData[] = "Не найден прайс для значения $tonnage";
        }

        if (!empty($incorrectData)) {
            echo "Выполнение команды завершено с ошибкой" . PHP_EOL .
                implode(PHP_EOL, $incorrectData) . PHP_EOL .
                "проверьте корректность введенных значений";
            return ExitCode::DATAERR;
        }

        echo "Тип - $raw_type" . PHP_EOL .
            "Месяц - $month" . PHP_EOL .
            "Тоннаж - $tonnage" . PHP_EOL;

        print_r("Результат - " . \Yii::$app->params['prices'][$raw_type][$month][$tonnage]);

        echo PHP_EOL;

        $this->drawTable(\Yii::$app->params['prices'], $raw_type);

        return ExitCode::OK;
    }

    public function drawTable(array $prices, string $raw_type)
    {

        $table = new ConsoleTable();

        $monthsArr = array_keys($prices[$raw_type]);
        $tonnagesArr = array_keys($prices[$raw_type][$monthsArr[0]]);

        $table->setHeaders(array_merge(['М/Т'], $monthsArr));

        foreach ($tonnagesArr as $tonnage) {
            $row = [$tonnage];
            foreach ($monthsArr as $month) {
                $row[] = $prices[$raw_type][$month][$tonnage];
            }
            $table->addRow($row);
        }
        Console::output($table->getTable());
    }
}
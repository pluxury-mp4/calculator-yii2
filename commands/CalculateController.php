<?php

namespace app\commands;

use app\models\DataBasePricesRepository;
use LucidFrame\Console\ConsoleTable;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Query;
use yii\helpers\Console;

class CalculateController extends Controller
{
    public function actionIndex($raw_type = "", $month = "", $tonnage = 0)
    {
        $repository = new DataBasePricesRepository();
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

            $this->stdout("Выполнение команды завершено с ошибкой" . PHP_EOL .
                "Необходимо ввести " . implode(", ", $missingParams), Console::FG_RED);
            return ExitCode::DATAERR;
        }

        $incorrectData = [];
        if (in_array($raw_type, $repository->getRawTypesListFromDb()) === false) {
            $incorrectData[] = "Не найден прайс для значения $raw_type";
        }

        if (in_array($month, $repository->getMonthsListFromDb()) === false) {
            $incorrectData[] = "Не найден прайс для значения $month";
        }

        if (in_array($tonnage, $repository->getTonnagesListFromDb()) === false) {
            $incorrectData[] = "Не найден прайс для значения $tonnage";
        }

        if (!empty($incorrectData)) {
            $this->stdout("Выполнение команды завершено с ошибкой" . PHP_EOL .
                implode(PHP_EOL, $incorrectData) . PHP_EOL .
                "проверьте корректность введенных значений", Console::FG_RED);
            return ExitCode::DATAERR;
        }

        echo "Тип - $raw_type" . PHP_EOL .
            "Месяц - $month" . PHP_EOL .
            "Тоннаж - $tonnage" . PHP_EOL .
            "Результат - " . $repository->getPriceFromDb($raw_type, $month, $tonnage) . PHP_EOL;

        $this->drawTable($raw_type);

        return ExitCode::OK;
    }

    public function drawTable(string $raw_type)
    {
        $repository = new DataBasePricesRepository();
        $table = new ConsoleTable();

        $monthsHeaders = (new Query())->select('name')->groupBy('id')->from('months')->column();

        $table->setHeaders(array_merge(['М/Т'], $monthsHeaders));

        foreach ($repository->getTonnagesListFromDb() as $tonnage) {
            $row = [$tonnage];
            foreach ($repository->getMonthsListFromDb() as $month) {
                $row[] = Console::ansiFormat($repository->getPriceFromDb($raw_type, $month, $tonnage), [Console::FG_GREEN]);
            }
            $table->addRow($row);
        }
        Console::output($table->getTable());
    }
}
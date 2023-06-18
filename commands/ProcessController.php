<?php


namespace app\commands;

use app\models\CalculatorForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ProcessController extends \yii\console\Controller
{
    public function actionQueueResult()
    {
        $bathfile = Yii::getAlias('runtime/queue.job');

        $counter = 1;

        while (true) {
            echo "Счетчик " . $counter++, PHP_EOL;
            if (file_exists($bathfile)) {
                echo file_get_contents($bathfile);
                unlink($bathfile);
            }
            sleep(2);
        }
    }
}
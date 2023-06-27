<?php


namespace app\commands;

use Yii;

class ProcessController extends \yii\console\Controller
{
    public function actionQueueResult()
    {
        $filePath = Yii::getAlias('runtime/queue.job');

        $counter = 1;

        while (true) {
            echo "Счетчик " . $counter++, PHP_EOL;
            if (file_exists($filePath)) {
                echo file_get_contents($filePath);
                unlink($filePath);
            }
            sleep(2);
        }
    }
}
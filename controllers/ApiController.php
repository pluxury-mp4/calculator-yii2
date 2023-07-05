<?php

namespace app\controllers;

use app\models\CalculatorForm;
use app\models\PricesRepository;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionCalculatePrice()
    {
        $model = new CalculatorForm;
        $repository = new PricesRepository(\Yii::$app->params['prices']);

        try {
            if ($model->load(\Yii::$app->request->get(), '')) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if (empty($model->raw_type)) {
                    throw new BadRequestHttpException('Не задан параметр \'Тип сырья\'');
                }

                if(in_array($model->raw_type,$repository->getRawTypesList()) === false){
                    throw new BadRequestHttpException('Параметр \'Тип сырья\' не найден в таблице');
                }

                
                if (empty($model->month)) {
                    throw new BadRequestHttpException('Не задан параметр \'Месяц\'');
                }
               if(in_array($model->month,$repository->getMonthsList()) === false){
                throw new BadRequestHttpException('Параметр \'Месяц\' не найден в таблице');
               }

               if (empty($model->tonnage)) {
                throw new BadRequestHttpException('Не задан параметр \'Тоннаж\'');
                }
            
                if (in_array($model->tonnage,$repository->getTonnagesList()) === false) {
                    throw new BadRequestHttpException('Параметр \'Тоннаж\' не найден в таблице');
                }
            }

        } catch (BadRequestHttpException $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
        return [
            'price' => $repository->getPrice($model->raw_type, $model->month, $model->tonnage),
            'price_list' => $repository->getPrices(),
        ];
    }
}



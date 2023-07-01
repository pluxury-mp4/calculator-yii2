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


                $outListType = true;
                foreach ($repository->getRawTypesList() as $raw_type) {

                    if (empty($model->raw_type)) {
                        throw new BadRequestHttpException('Не задан параметр \'Тип сырья\'');
                    }

                    if ($model->raw_type === $raw_type) {
                        $outListType = false;
                    }

                }
                if ($outListType) {
                    throw new BadRequestHttpException('Параметр \'Тип сырья\' не найден в таблице');
                }

                $outListMonth = true;
                foreach ($repository->getMonthsList() as $month) {

                    if (empty($model->month)) {
                        throw new BadRequestHttpException('Не задан параметр \'Месяц\'');
                    }

                    if ($model->month == $month) {
                        $outListMonth = false;
                    }

                }
                if ($outListMonth) {
                    throw new BadRequestHttpException('Параметр \'Месяц\' не найден в таблице');
                }

                $outListTonnage = true;
                foreach ($repository->getTonnagesList() as $tonnage) {

                    if (empty($model->tonnage)) {
                        throw new BadRequestHttpException('Не задан параметр \'Тоннаж\'');
                    }

                    if ($model->tonnage === $tonnage) {
                        $outListTonnage = false;
                    }

                }
                if ($outListTonnage) {
                    throw new BadRequestHttpException('Параметр \'Тоннаж\' не найден в таблице');
                }
            }

        } catch (BadRequestHttpException $e) {
            return [
                'error' => $e->getMessage(),
                'price_list' => $repository->getPrices(),
            ];
        }
        return [
            'price' => $repository->getPrice($model->raw_type, $model->month, $model->tonnage),
            'price_list' => $repository->getPrices(),
        ];
    }
}



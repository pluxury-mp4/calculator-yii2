<?php

namespace app\controllers;

use app\models\CalculatorForm;
use app\models\DataBasePricesRepository;
use app\models\History;
use app\models\HistorySearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\Controller;

class CalculationController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new HistorySearch();



        if (Yii::$app->user->can('administrator')) {
            $dataProvider = $searchModel->search(Yii::$app->request->get());
        } else {
            $dataProvider = $searchModel->userSearch(Yii::$app->request->get());
        }

        return $this->render('index', compact( 'dataProvider','searchModel'));
    }

    public function actionSave()
    {
        $model = new CalculatorForm();
        $repository = new DataBasePricesRepository();

        $model->load(Yii::$app->request->post());
        $price = $repository->getPriceFromDb($model->raw_type, $model->month, $model->tonnage);

        $snapshot = json_encode($repository->getAllPrices($model->raw_type));
        $calculation = new History([
            'user_id' => Yii::$app->user->id,
            'username' => Yii::$app->user->identity->username,
            'month' => $model->month,
            'tonnage' => $model->tonnage,
            'raw_type' => $model->raw_type,
            'snapshot' => $snapshot,
            'price' => $price,
        ]);
        $calculation->save();

        Yii::$app->response->format = Response::FORMAT_JSON; //мб не надо
        return ['success' => true, 'price' => $price]; //мб тоже не надо
    }

    public function actionView($id)
    {
        $history = History::findOne($id);

        if (Yii::$app->user->can('readSnapshot', ['ownerSnapshot' => $history->user_id]))
            return $this->render('view', compact('history'));


        throw new ForbiddenHttpException('Доступ запрещен');
    }

    public function actionDelete($id)
    {
        $calculation = History::findOne($id);

        if (Yii::$app->user->can('deleteSnapshot')) {
            $calculation->delete();
            return $this->redirect('index');
        }
        return ['success' => true];
    }



}
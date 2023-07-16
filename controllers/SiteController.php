<?php

namespace app\controllers;

use app\models\CalculatorForm;
use app\models\DataBasePricesRepository;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PricesRepository;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    //Calculator page
    public function actionIndex()
    {
        $filePath = Yii::getAlias('../runtime/queue.job');

        $model = new CalculatorForm;
        $repository = new DataBasePricesRepository();

        if ($model->load(Yii::$app->request->post())) {

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            foreach ($model->getAttributes() as $key => $value) {
                file_put_contents($filePath, "$key => $value \n", FILE_APPEND);
            }
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return $this->renderAjax('result', ['model'=>$model,'repository'=>$repository]);
        }

        return $this->render('index', ['model' => $model, 'repository' => $repository]);
    }

    public function actionValidation()
    {
        $model = new CalculatorForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}
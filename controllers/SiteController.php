<?php

namespace app\controllers;

use app\models\CalculatorForm;
use app\models\DataBasePricesRepository;
use app\models\User;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

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
                'only'=>['logout'],
                'rules' => [
                    [
                        'actions' => ['logout, profile'],
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
        $session = Yii::$app->session;

        $model = new CalculatorForm;
        $repository = new DataBasePricesRepository();

        // Проверяем, авторизован ли пользователь
        if (!Yii::$app->user->isGuest) {
            // Проверяем, было ли уже показано уведомление пользователю
            if (!$session->has('alertShowed')) {
                $session->set('alertShowed', true);

                // Получаем имя пользователя
                $username = Yii::$app->user->identity->username;

                // Выводим сообщение и ссылку на журнал расчетов
                Yii::$app->session->addFlash('success', "Здравствуйте, 
                $username, вы авторизовались в системе расчета стоимости доставки. 
                Теперь все ваши расчеты будут сохранены для последующего просмотра в " .
                    '<a class="alert-link" href="' . Url::to(['/calculation/history']) .
                    '">журнале расчетов</a>');
            }
        }

        if ($model->load(Yii::$app->request->post())) {

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            foreach ($model->getAttributes() as $key => $value) {
                file_put_contents($filePath, "$key => $value \n", FILE_APPEND);
            }
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return $this->renderAjax('result', ['model' => $model, 'repository' => $repository]);
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

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('profile');
    }
}
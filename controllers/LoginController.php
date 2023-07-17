<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class LoginController extends Controller
{

    public function actionSignup()
    {
        $model = new SignupForm();

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $user = new User();

            $user->email = $model->email;
            $user->username = $model->username;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);

            if($user->save()){
                \Yii::$app->user->login($user);
                return $this->goHome();
            }

        }

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
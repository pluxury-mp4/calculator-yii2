<?php

namespace app\controllers;

use app\models\SignupForm;
use app\models\UpdateForm;
use app\models\UserSearch;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\web\Controller;
use app\models\User;
use yii\web\Response;

class UsersController extends Controller
{
    // Доступ только для пользователей с ролью "Администратор"
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ];
    }

    // Просмотр всех пользователей
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    // Изменение пользователя
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        $model = new UpdateForm();

        $model->username = $user->username;
        $model->email = $user->email;


        if ($model->load(Yii::$app->request->post()) && $user->save()) {
            $user->username = $model->username;
            $user->email = $model->email;
            $user->save();
            Yii::$app->session->setFlash('success', 'Пользователь успешно обновлен.');
            return $this->redirect(['index']);
        }


        return $this->render('update', [
            'user' => $user,
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new SignupForm();
        $user = new User();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->request->post())) {

            $user->email = $model->email;
            $user->username = $model->username;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            $user->created_at = date('y-m-d H:i:s');
            $user->updated_at = date('y-m-d H:i:s');
            $user->save(false);

            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());

            if ($user->save()) {
                $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    // Удаление пользователя
    public function actionDelete($id)
    {
        $user = User::findOne($id);

        if ($user) {
            $user->delete();
            Yii::$app->session->setFlash('success', 'Пользователь успешно удален.');
        }

        return $this->redirect(['index']);
    }
}

?>
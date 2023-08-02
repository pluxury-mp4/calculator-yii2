<?php

namespace app\controllers;

use app\models\UpdateForm;
use Yii;
use yii\web\Controller;
use app\models\User;

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
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
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
            'model'=>$model
        ]);
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
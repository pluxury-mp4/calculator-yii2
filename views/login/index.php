<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Авторизация';

$form = \yii\bootstrap5\ActiveForm::begin([
    'id' => 'signup-form',
]);

?>
<div class="d-flex justify-content-center align-items-center " style="min-height: 75vh;">

    <div class="shadow  p-5 mb-5 bg-body rounded-3 ">

        <h1 class="text-center">Авторизация</h1>

        <p>Пожалуйста, заполните следующие поля для входа в систему:</p>
        <div>
            <div class="mb-3">
                <?=
                $form->field($model, 'email')->textInput(['autofocus' => true])->label('Email');
                ?>
            </div>
            <div class="mb-3">
                <?=
                $form->field($model, 'password')->passwordInput()->label('Пароль');
                ?>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col">
                    <?= Html::submitButton($content = "Войти", ['id' => 'signup-button', 'class' => 'btn btn-success']) ?>
                </div>
                <div class="col-3">
                </div>
                <div class="col mt-2">
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"custom-control custom-checkbox \">{input} {label}</div>\n<div class=\"col-lg-8 \">{error}</div>",
                    ])->label('Запомнить меня') ?>
                </div>
            </div>
        </div>
        <p class="text-center">Еще не зарегистрированны? <a href="/login/signup">Регистрация</a></p>
    </div>

    <?php \yii\bootstrap5\ActiveForm::end() ?>





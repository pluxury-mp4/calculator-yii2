<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Регистрация";
$form = \yii\bootstrap5\ActiveForm::begin([
    'id' => 'signup-form',
    'enableAjaxValidation' => true,
]);
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="shadow  p-5 mb-5 bg-body rounded-3">
        <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для регистрации в системе:</p>



            <div>
                <div class="mb-3">
                    <?=
                    $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя');
                    ?>
                </div>
                <div class="mb-3">
                    <?=
                    $form->field($model, 'email')->textInput()->label('Email');
                    ?>
                </div>
                <div class="mb-3">
                    <?=
                    $form->field($model, 'password')->passwordInput()->label('Пароль');
                    ?>
                </div>
                <div class="mb-3">
                    <?=
                    $form->field($model, 'passwordVerify')->passwordInput()->label('Подтверждение пароля');
                    ?>
                </div>
            </div>

            <?= Html::submitButton($content = "Зарегистрироваться", ['id' => 'signup-button', 'class' => 'btn btn-success']) ?>

            <?php \yii\bootstrap5\ActiveForm::end() ?>

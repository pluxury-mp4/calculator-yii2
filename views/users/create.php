<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Создание пользователя';
$form = ActiveForm::begin([
    'id' => 'create-form',
    'enableAjaxValidation' => true,
]);?>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 75vh;">

    <div class="shadow  p-5 bg-body rounded-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <div>
        <div class="mb-3">
            <?= $form->field($model, 'username')->textInput() ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'email')->textInput() ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>

<?= Html::a('Отмена', Yii::$app->request->referrer, ['class' => 'btn btn-danger me-3']); ?>
<?= Html::submitButton($content = "Сохранить", ['id' => 'save-button', 'class' => 'btn btn-success']) ?>

<?php \yii\bootstrap5\ActiveForm::end() ?>
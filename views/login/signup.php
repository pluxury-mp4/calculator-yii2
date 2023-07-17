<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Регистрация";
$form = \yii\bootstrap5\ActiveForm::begin([
    'id' => 'signup-form',
    //'validationUrl' => Url::toRoute('site/validation'),
    //'enableAjaxValidation' =>true,
]);
?>

    <div class=row>
    <h2>
        Регистрация
    </h2>

    <div class="col-lg-5">
    <fieldset class="form-control">
    <div>
        <div class="mb-3">
            <?=
            $form->field($model, 'username')->textInput()->label('Имя');
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


<?php
$js = <<<JS
        $('#calculator-form').on('beforeSubmit', function (){
        var data = $(this).serialize();
        $.ajax({
            url:'/site/index',
            type: 'POST',
            data: data,
            success: function(response) {
                    $('#result').html(response); // Вставка HTML-response 
            },
            error: function() {
                alert('Произошла ошибка при отправке запроса');
            }
             });
        return false;
    })
    JS;
$this->registerJs($js);
?>
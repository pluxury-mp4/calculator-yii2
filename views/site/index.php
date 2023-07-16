<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = "Calculator";
$form = \yii\bootstrap5\ActiveForm::begin([
    'id' => 'calculator-form',
      'validationUrl' => Url::toRoute('site/validation'),
      'enableAjaxValidation' =>true,
]);
?>

    <div class="container mt-2 w-75">
    <h2>
        Калькулятор стоимости доставки сырья
    </h2>

    <div class="d-flex justify-content-center">
    <fieldset class="form-control">
    <div>
        <div class="mb-3">
            <?=
            $form->field($model, 'month')->
            dropDownList(
                $repository->getMonthsListFromDb(),
                ['prompt' => 'Выберите параметр']
            );
            ?>
        </div>
        <div class="mb-3">

            <?=
            $form->field($model, 'raw_type')
                ->dropDownList(
                    $repository->getRawTypesListFromDb(),
                    ['prompt' => 'Выберите параметр'],
                );
            ?>
        </div>
        <div class="mb-3">
            <?=
            $form->field($model, 'tonnage')
                ->dropDownList(
                    $repository->getTonnagesListFromDb(),
                    ['prompt' => 'Выберите параметр'],
                );
            ?>
        </div>
    </div>

    <?= Html::submitButton($content = "Рассчитать", ['id' => 'calculate-button', 'class' => 'btn btn-success']) ?>

    <?php \yii\bootstrap5\ActiveForm::end() ?>

    <div id="result"></div>


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
<?php

use app\models\CalculatorForm;
use yii\helpers\Html;

$this->title = "Calculator";

$form = \yii\widgets\ActiveForm::begin();
$model = new CalculatorForm();
?>
<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <fieldset class="form-control" id="disabledInput" type="text" placeholder="Disabled input here...">
            <legend>Калькулятор расчета стоимости доставки</legend>
            <div>
                <div class="mb-3">
                    <?= $form->field($model, 'month')->dropDownList([
                        'Январь' => 'Январь',
                        'Февраль' => 'Февраль',
                        'Август' => 'Август',
                        'Сентябрь' => 'Сентябрь',
                        'Октябрь' => 'Октябрь',
                        'Ноябрь' => 'Ноябрь',
                    ]);
                    ?>
                </div>
                <div class="mb-3">
                    <?= $form->field($model, 'raw_type')->dropDownList([
                        'Шрот' => 'Шрот',
                        'Жмых' => 'Жмых',
                        'Соя' => 'Соя',
                    ]);
                    ?>
                </div>
                <div class="mb-3">
                    <?= $form->field($model, 'tonnage')->dropDownList([
                        '25' => '25',
                        '50' => '50',
                        '75' => '75',
                        '100' => '100',
                    ]);
                    ?>
                </div>
            </div>
            <?= Html::submitButton($content = "Рассчитать", ["class" => "btn btn-success"]) ?>
        </fieldset>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end() ?>

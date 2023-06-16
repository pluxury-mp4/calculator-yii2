<?php

use app\models\CalculatorForm;
use yii\helpers\Html;
use app\config\Prices;

$this->title = "Calculator";

$form = \yii\widgets\ActiveForm::begin();
$price = new Prices();
?>
<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <fieldset class="form-control" id="disabledInput" type="text" placeholder="Disabled input here...">
            <legend>Калькулятор стоимости доставки сырья</legend>
            <div>
                <div class="mb-3">
                    <?= $form->field($model, 'month')->dropDownList([
                        'Январь' => 'Январь',
                        'Февраль' => 'Февраль',
                        'Август' => 'Август',
                        'Сентябрь' => 'Сентябрь',
                        'Октябрь' => 'Октябрь',
                        'Ноябрь' => 'Ноябрь',
                    ], [
                        'prompt' => 'Выберите параметр'
                    ]);
                    ?>
                </div>
                <div class="mb-3">
                    <?= $form->field($model, 'raw_type')->dropDownList([
                        'Шрот' => 'Шрот',
                        'Жмых' => 'Жмых',
                        'Соя' => 'Соя',
                    ], [
                        'prompt' => 'Выберите параметр'
                    ]);
                    ?>
                </div>
                <div class="mb-3">
                    <?= $form->field($model, 'tonnage')->dropDownList([
                        '25' => '25',
                        '50' => '50',
                        '75' => '75',
                        '100' => '100',
                    ], [
                        'prompt' => 'Выберите параметр'
                    ]);
                    ?>
                </div>
            </div>
            <?= Html::submitButton($content = "Рассчитать", ["class" => "btn btn-success"]) ?>
            <?php
            if (!empty($model->raw_type)){
            ?>
<div>
            <p class="pt-2 fs-6 ">
               Выбранный месяц:
                <strong> <?=$model->month?> </strong><br>
                Выбранный тип сырья:
                <strong><?=$model->raw_type?> </strong><br>
                Выбранный тоннаж:
                <strong> <?=$model->tonnage?></strong> <br>
                Итог:
                <strong> <?=$price->price[$model->raw_type][$model->month][$model->tonnage]?> </strong> <br>
            </p>
</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>
                            Месяц/Тоннаж
                        </th>
                        <?php
                        foreach ($price->price[$model->raw_type][$model->month] as $key => $value):?>
                            <th>
                            <?= $key ?>
                            </th>
                        <?php endforeach ?>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach (array_keys($price->price[$model->raw_type]) as $value): ?>
                    <tr>
                        <td>
                            <?= $value ?>
                        </td>
                        <?php foreach ($price->price[$model->raw_type][$value] as $key => $val): ?>
                            <td>
                                <?= $val ?>
                            </td>
                        <?php endforeach ?>
                        <?php endforeach ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
</div>

<?php } ?>
<?php \yii\widgets\ActiveForm::end() ?>

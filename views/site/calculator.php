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
                    ],[
                            'prompt' => 'Выберите параметр'
                    ]);
                    ?>
                </div>
                <div class="mb-3">
                    <?= $form->field($model, 'raw_type')->dropDownList([
                        'Шрот' => 'Шрот',
                        'Жмых' => 'Жмых',
                        'Соя' => 'Соя',
                    ],[
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
                    ],[
                        'prompt' => 'Выберите параметр'
                    ]);
                    ?>
                </div>
            </div>
            <?= Html::submitButton($content = "Рассчитать", ["class" => "btn btn-success"]) ?>

            <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Месяц/Тоннаж
                                    </th>
                                    <?php foreach ($price->shrot['25'] as $key => $value): ?>
                                        <th>
                                            <?= $key ?>
                                        </th>
                                    <?php endforeach ?>
                                </tr>
                            </thead>
                            <tbody>



                                <?php foreach (array_keys($price->shrot) as $value): ?>
                                    <tr>
                                        <td>
                                            <?= $value ?>
                                        </td>
                                            <?php foreach ($price->shrot[$value] as $key => $val): ?>
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
<?php \yii\widgets\ActiveForm::end() ?>

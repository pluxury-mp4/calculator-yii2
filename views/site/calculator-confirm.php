<?php

use app\models\CalculatorForm;
use app\config\Prices;

$this->title = "Calculator";

$form = \yii\widgets\ActiveForm::begin();
$model = new CalculatorForm();
$price = new Prices();
?>
<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <fieldset class="form-control" id="disabledInput" type="text" placeholder="Disabled input here...">
            <legend>Калькулятор стоимости доставки сырья</legend>
            <div>
                <div class="mb-3">
                    <p>Выбранные параметры: </p>

                    Месяц:
                    <?php
                    echo (implode([$_POST['CalculatorForm']['month']]));
                    ?> <br>

                    Тип сырья:
                    <?php
                    echo (implode([$_POST['CalculatorForm']['raw_type']]));
                    ?><br>

                    Тоннаж:
                    <?php
                    echo (implode([$_POST['CalculatorForm']['tonnage']]));
                    ?><br>

                </div>

                <div class="mb-3">
                    <p>
                        Результат:
                        <?php

                        $tonnage = $_POST['CalculatorForm']['tonnage'];
                        $month = $_POST['CalculatorForm']['month'];
                        $type = $_POST['CalculatorForm']['raw_type'];

                        $result = 0;

                        $shrot = $price->shrot;
                        $jmih = $price->jmih;
                        $soya = $price->soya;

                        switch ($type) {
                            case ('Жмых'):
                                print_r($jmih[$tonnage][$month]);
                                break;
                            case ('Шрот'):
                                print_r($shrot[$tonnage][$month]);
                                break;
                            case ('Соя'):
                                print_r($soya[$tonnage][$month]);
                                break;
                        }
                        ?>
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
                    </p>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end() ?>
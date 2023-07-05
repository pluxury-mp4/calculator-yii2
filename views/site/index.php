<?php

use yii\helpers\Html;

$this->title = "Calculator";

$form = \yii\bootstrap5\ActiveForm::begin();
?>
<div class="container mt-2 w-75">
    <h2>
        Калькулятор стоимости доставки сырья
    </h2>
    <div class="d-flex justify-content-center">
        <fieldset class="form-control" id="disabledInput" type="text" placeholder="Disabled input here...">
            <div>
                <div class="mb-3">
                    <?=
                    $form->field($model, 'month')->
                    dropDownList(
                        $repository->getMonthsList(),
                        ['prompt' => 'Выберите параметр']
                    );
                    ?>
                </div>
                <div class="mb-3">

                    <?=
                    $form->field($model, 'raw_type')
                        ->dropDownList(
                            $repository->getRawTypesList(),
                            ['prompt' => 'Выберите параметр'],
                        );
                    ?>
                </div>
                <div class="mb-3">
                    <?=
                    $form->field($model, 'tonnage')
                        ->dropDownList(
                            $repository->getTonnagesList(),
                            ['prompt' => 'Выберите параметр'],
                        );
                    ?>
                </div>
            </div>

            <?= Html::submitButton($content = "Рассчитать", ["class" => "btn btn-success"]) ?>

            <?php \yii\bootstrap5\ActiveForm::end() ?>

            <?php
            if (!empty($model->raw_type)){
            ?>
            <div class="row">
                <div class="col-md-5 mt-2 mb-2">
                    <div class="card">
                        <div class="card-body">
                            Введенные данные:
                            <?php foreach ($model->getAttributes() as $key => $attribute): ?>
                                <div>
                                    <?= $model->getAttributeLabel($key) ?>: <strong><?= $attribute ?></strong>
                                </div>
                            <?php endforeach ?>
                            <div>
                                Итог, руб. :
                                <strong> <?= $repository->getPrice($model->raw_type, $model->month, $model->tonnage) ?> </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <th>
                        Месяц/Тоннаж
                    </th>
                    <?php
                    foreach ($repository->getTonnagesByRawTypeAndMonth($model->raw_type, $model->month) as $tonnages):?>
                        <th>
                            <?= $tonnages ?>
                        </th>
                    <?php endforeach ?>
                    </thead>
                    <tbody>
                    <?php foreach ($repository->getMonthsByRawType($model->raw_type) as $month): ?>
                        <tr>
                            <td>
                                <?= $month ?>
                            </td>
                            <?php foreach ($repository->getPriceByRawTypeAndMonth($model->raw_type, $month) as $price): ?>
                                <td>
                                    <?= $price ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
</div>
<?php } ?>


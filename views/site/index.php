<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Calculator";
$form = \yii\bootstrap5\ActiveForm::begin([
    'id' => 'calculator-form',
    'enableAjaxValidation' => true,
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

                <?= Html::submitButton($content = "Рассчитать", ["class" => "btn btn-success"]) ?>



                <?php
                \yii\bootstrap5\ActiveForm::end()
                ?>

                <?php

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
                                    <strong> <?= $repository->getPriceFromDb($model->raw_type, $model->month, $model->tonnage) ?> </strong>
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
                        foreach ($repository->getTonnagesListFromDb() as $tonnages):?>
                            <th>
                                <?= $tonnages ?>
                            </th>
                        <?php endforeach ?>
                        </thead>
                        <tbody>
                        <?php foreach ($repository->getMonthsListFromDb() as $month): ?>
                            <tr>
                                <td>
                                    <?= $month ?>
                                </td>
                                <?php foreach ($repository->getPriceArrayFromDb($model->raw_type, $month) as $price): ?>
                                    <td>
                                        <?= $price ?>
                                    </td>
                                <?php endforeach ?>
                            </tr>
                        <?php endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>


<?php
$js = <<<JS
     $('form').on('beforeSubmit', function(){
	 var data = $(this).serialize();
	 $.ajax({
	    url: '/index/index',
	    type: 'POST',
	    data: data,
	    success: function(res){
	       console.log(res);
	    },
	    error: function(){
	       alert('Error!');
	    }
	 });
	 return false;
     });
JS;

$this->registerJs($js);
?>
<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;

?>

<div class="container">
    <div class="row d-flex justify-content-center align-items-center" style="min-height: 75vh;">

        <div class="col-sm-5 shadow p-3 bg-body-tertiary rounded-4">
            <h4>Расчет #<?= $history->id ?></h4>
            <?= DetailView::widget([
                    'model' => $history,
                    'options' => ['class' => 'table table-borderless table-sm table-light'],

                    'attributes' => [
                        'month',
                        'raw_type',
                        'tonnage',
                        'price',
                        ['visible' => Yii::$app->user->can('administrator'),
                            'value' => $history->username,
                            'label' => 'Автор расчета'
                        ],
                        'created_at',
                    ],

                ]
            ); ?>
            <h4>Таблица расчета</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <th>
                        Месяц/Тоннаж
                    </th>
                    <?php
                    foreach ($history->getSnapshotArray($history->id)[$history->month] as $tonnage => $value):?>
                        <th>
                            <?= $tonnage ?>
                        </th>
                    <?php endforeach ?>
                    </thead>
                    <tbody>
                    <?php foreach ($history->getSnapshotArray($history->id) as $month => $value): ?>
                        <tr>
                            <td>
                                <?= $month ?>
                            </td>
                            <?php foreach ($history->getSnapshotArray($history->id)[$history->month] as $tonnage => $price): ?>
                                <td>
                                    <?= $history->getSnapshotArray($history->id)[$month][$tonnage] ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
            <?= Html::a( 'Назад', Yii::$app->request->referrer, ['class' => 'btn btn-primary']); ?>
        </div>

    </div>
</div>

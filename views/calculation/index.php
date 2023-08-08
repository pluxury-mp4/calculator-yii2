<?php

use yii\bootstrap5\Html;
use \yii\grid\GridView;
use yii\widgets\Pjax;

$this->title='История расчетов'
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'tableOptions' => [
                'class' => 'table table-striped table-hover shadow-sm '
        ],
        'layout'=>"{summary}\n{items}\n{pager}",
        'pager'=>['class'=>'yii\bootstrap5\LinkPager'],
        'columns' => [
            'id',
            ['visible' => Yii::$app->user->can('administrator'),
                'label' => 'Имя пользователя',
                'attribute' =>
                    'username',
            ],
            'raw_type',
            'tonnage',
            'month',
            'price',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete} ',
                'visibleButtons' => [
                        'delete' => Yii::$app->user->can('administrator'),
                ]
            ],
        ],



    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
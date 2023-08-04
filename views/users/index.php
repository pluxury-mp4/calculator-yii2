<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title='Управление пользователями'
?>

    <h1><?= Html::encode($this->title) ?></h1>
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
        ['attribute'=>'username', 'label' => 'Имя пользователя'],
        ['attribute'=>'email', 'label' => 'Email'],
        ['attribute'=>'created_at', 'label' => 'Дата создания'],
        ['attribute'=>'updated_at', 'label' => 'Дата обновления'],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]) ?>
<?php Pjax::end(); ?>

<?php

use yii\grid\GridView;
use yii\helpers\Html;
$this->title='Управление пользователями'
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([

    'tableOptions' => [
        'class' => 'table table-striped table-hover shadow-sm '
    ],
    'dataProvider' => $dataProvider,
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
<?php

?>
<div class="d-flex justify-content-center align-items-center " style="min-height: 75vh">
    <div class="shadow p-5 mb-3 bg-body rounded-3 w-75">
        <h1 class="mb-3">
            Привет, <?= Yii::$app->user->identity->username ?>!
        </h1>

        <div>
            <p>id: <?= Yii::$app->user->id ?></p>
            <p>email: <?= Yii::$app->user->identity->email ?></p>
            <p>Дата создания аккаунта: <?= Yii::$app->user->identity->created_at ?></p>
        </div>



<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top '],
        'brandLabel' => 'Расчет доставки',
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-lg-0'],
        'items' => [
            Yii::$app->user->isGuest
                ? ['label' => 'Войти в систему', 'url' => ['login/login']]
                : ['label' => Yii::$app->user->identity->username, 'items' => [
                ['label' => 'Профиль', 'url' => ['/site/profile']],
                ['label' => 'История расчетов', 'url' => ['/calculation/history']],
                ['label' => 'Пользователи', 'url' => ['/users/index'], 'visible' => Yii::$app->user->can('administrator')],
                ['label' => 'Выход', 'url' => ['/login/logout']],
            ]],

        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; ЭФКО Стартер <?= date('Y') ?></div>
        </div>
    </div>
</footer>

<!--Disable debug toolbar-->
<?php
//if (class_exists('yii\debug\Module')) {
//    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
//}

$this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>

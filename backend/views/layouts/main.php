<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage();?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language;?>">
<head>
    <meta charset="<?=Yii::$app->charset;?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags();?>
    <title><?=Html::encode($this->title);?></title>
    <?php $this->head();?>
</head>
<body>
<?php $this->beginBody();?>

<div class="wrap">
    <?php
NavBar::begin([
    'brandLabel' => '原象屋管理后台',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [
    // ['label' => '主页', 'url' => ['/site/index']],

    ['label' => '公司管理', 'url' => ['/yx-company/index']],
    ['label' => '用户管理', 'url' => ['/yx-user/index']],
    
    ['label' => '员工管理', 'url' => ['/yx-staff/index']],
    ['label' => '审核管理',
        'url' => ['/yx-company-verify/index'],
        'items' => [
            ['label' => '公司审核', 'url' => ['/yx-company-verify/index']],
            ['label' => '员工审核', 'url' => ['/yx-staff-verify/index']],
        ],
    ],
    ['label' => '分类管理', 'url' => ['/yx-server/index']],
    
    ['label' => '订单管理', 'url' => ['/yx-order/index']],
    ['label' => '图片管理',
        'url' => ['/yx-banner/index'],
        'items' => [
            ['label' => '轮播图', 'url' => ['/yx-banner/index']],
            ['label' => '推荐左图', 'url' => ['/yx-recom-left/index']],
            ['label' => '推荐右图', 'url' => ['/yx-recom-right/index']],
            ['label' => '活动图', 'url' => ['/yx-activity/index']],
        ],
    ],
    ['label' => '其他',
        'url' => ['/yx-rules/index'],
        'items' => [
            ['label' => '公告管理', 'url' => ['/yx-notice/index']],
            ['label' => '富文本管理', 'url' => ['/yx-rules/index']],
            ['label' => '管理员管理', 'url' => ['/user/index']],
            ['label' => '地区管理', 'url' => ['/region/index']],
        ],
    ],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = '<li>'
    . Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
        'Logout (' . Yii::$app->user->identity->username . ')',
        ['class' => 'btn btn-link logout']
    )
    . Html::endForm()
        . '</li>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

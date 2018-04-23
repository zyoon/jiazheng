<?php

/* @var $this \yii\web\View */
/* @var $content string */

use console\assets\AppAsset;
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
    'brandLabel' => "原象屋商家后台",
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
        

$menuItems = [

    // ['label' => '人员审核', 'url' => ['/yx-staff-verify/index']],
    // ['label' => '省市区', 'url' => ['/region/index']],


    // // ['label' => '公司审核', 'url' => ['/yx-company-verify/index']],
    // // ['label' => '员工审核', 'url' => ['/yx-staff-verify/index']],
    // ['label' => '服务分类', 'url' => ['/yx-server/index']],
    // ['label' => '七牛测试', 'url' => ['/test-h/index']],

    // ['label' => '图片管理',
    //     'url' => ['/yx-order/index'],
    //     'items' => [
    //         ['label' => '轮播图', 'url' => ['/yx-banner/index']],
    //         ['label' => '推荐左图', 'url' => ['/yx-recom-left/index']],
    //         ['label' => '推荐右图', 'url' => ['/yx-recom-right/index']],
    //         ['label' => '活动图', 'url' => ['/yx-activity/index']],
    //     ],
    // ],

    // ['label' => '公告', 'url' => ['/yx-notice/index']],
    // ['label' => '规则', 'url' => ['/yx-rules/index']],
];
$user_info=Yii::$app->user->identity;
if(!empty($user_info['company_id'])){
    $menuItems[] = ['label' => '服务人员', 'url' => ['/yx-staff/index']];
    $menuItems[] = ['label' => '公司服务', 'url' => ['/yx-cmp-server/index']];
    $menuItems[] = ['label' => '成果展示', 'url' => ['/yx-cmp-res/index']];
    $menuItems[] = ['label' => '订单管理', 'url' => ['/yx-order/index']];
}
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
} else {
    $menuItems[]=['label' => '家政公司', 'url' => ['/yx-company/view']];
    $menuItems[] = ['label' => '审核',
        'url' => ['/yx-company-verify/index'],
        'items' => [
            ['label' => '公司审核', 'url' => ['/yx-company-verify/index']],
            ['label' => '员工审核', 'url' => ['/yx-staff-verify/index']],
        ],
    ];
    $menuItems[]=['label' => '重置密码', 'url' => ['/site/request-password-reset']];
    $menuItems[] = '<li>'
    . Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
        '退出 (' . Yii::$app->user->identity->username . ')',
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

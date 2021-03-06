<?php
/**
 * @var $this    yii\web\View
 * @var $content string
 * @var $user User
 */

use app\models\User;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;

$bundle = \app\assets\AppAsset::register($this);
$user = Yii::$app->user->identity;

?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<div class="wrapper">
    <!-- header logo: style can be found in header.less -->
    <nav class="navbar navbar-default navbar-header header">
        <a class="navbar-brand" href="/">
            <div class="navbar-brand-img"></div>
            <!--<img src="img/logo/lobiadmin-logo-text-white-32.png" class="hidden-xs" alt="" />-->
        </a>
        <!--Menu show/hide toggle button-->
        <ul class="nav navbar-nav pull-left show-hide-menu">
            <li>
                <a href="#" class="border-radius-0 btn font-size-lg" data-action="show-hide-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-items">
            <!--User avatar dropdown-->
            <ul class="nav navbar-nav navbar-right user-actions">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/img/logo/lobiadmin-logo-text-white-32.png"
                             class="user-avatar">
                        <span><i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo Url::to(['/sign-in/profile']) ?>"><span
                                        class="glyphicon glyphicon-user"></span> &nbsp;&nbsp;Profile</a>
                        </li>
                        <li><a href="<?php echo Url::to(['/sign-in/account']) ?>"><span
                                        class="fa fa-key"></span> &nbsp;&nbsp;Account</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo Url::to(['/sign-in/logout']) ?>" data-method="post">
                                <span class="glyphicon glyphicon-off"></span>
                                &nbsp;&nbsp;<?php echo Yii::t('app', 'Log out') ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix-xxs"></div>
        <div class="navbar-items-2">
            <ul class="nav navbar-nav navbar-actions">
                <li>
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-danger badge-xs">
                            <?php echo $user->getNotificationCount() ?>
                        </span>
                    </a>
                    <?php if (Yii::$app->user->can(User::ROLE_MANAGER)): ?>
                        <div class="dropdown-menu dropdown-notifications dropdown-timeline notification-news border-1 animated-fast flipInX">
                            <div class="notifications-heading border-bottom-1 bg-white">
                                <?php echo Yii::t('app', 'Requests') ?>
                            </div>
                            <ul class="notifications-body max-h-300">
                                <?php foreach ($user->getNotificationHolidays() as $items): ?>
                                    <?php /** @var $items \app\models\Holiday */ ?>
                                    <li style="cursor: pointer"
                                        data-url="<?php echo Url::to($items->getDetailUrl()) ?>">
                                        <div class="notification">
                                            <img class="notification-image"
                                                 src="/img/logo/plane.png"
                                                 alt="<?php echo $items->getCreatorPublicIdentity() ?>">
                                            <div class="notification-msg">
                                                <h5 class="notification-sub-heading text-gray-darker">
                                                    <?php echo $items->getNotificationText() ?>
                                                </h5>
                                                <p class="body-text"><i
                                                            class="fa fa-clock-o"></i> <?php echo $items->getDisplayDate() ?>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="notifications-footer border-top-1 bg-white text-center">
                                <?php echo Html::a(Yii::t('app', 'View all'), $user->getRequestUrl()) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </nav>

    <div class="menu">
        <div class="menu-heading">
            <div class="menu-header-buttons-wrapper clearfix">
                <button type="button" class="btn btn-info btn-menu-header-collapse">
                    <i class="fa fa-cogs"></i>
                </button>
                <!--Put your favourite pages here-->
                <div class="menu-header-buttons">
                    <a href="<?php echo Url::to(['/sign-in/profile']) ?>" class="btn btn-info btn-outline"
                       data-title="Profile">
                        <i class="fa fa-user"></i>
                    </a>
                    <a href="<?php echo Url::to(['/sign-in/account']) ?>" class="btn btn-info btn-outline"
                       data-title="Account">
                        <i class="fa fa-key"></i>
                    </a>
                    <a href="<?php echo Url::to(['/site/index']) ?>" class="btn btn-info btn-outline"
                       data-title="Calendar">
                        <i class="fa fa-calendar"></i>
                    </a>
                    <a href="<?php echo Url::to(['/holiday/index']) ?>" class="btn btn-info btn-outline"
                       data-title="Holiday">
                        <i class="fa fa-file"></i>
                    </a>
                </div>
            </div>
        </div>
        <nav>
            <?php

            echo \app\widgets\Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'linkTemplate' => '<a href="{url}"><i class="{icon} menu-item-icon"></i><span class="inner-text">{label}</span>{badge}</a>',
                'activateParents' => true,
                'encodeLabels' => false,
                'activeCssClass' => 'opened',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Request Holiday'),
                        'icon' => 'fa fa-file',
                        'visible' => Yii::$app->user->can(User::ROLE_USER),
                        'url' => ['/holiday/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Calendar'),
                        'icon' => 'fa fa-calendar',
                        'visible' => Yii::$app->user->can(User::ROLE_USER),
                        'url' => ['/site/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'All Requests'),
                        'icon' => 'fa fa-eye',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => Yii::$app->user->identity->getRequestUrl()
                    ],
                    [
                        'label' => Yii::t('app', 'Employees'),
                        'icon' => 'fa fa-users',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => ['/user/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Department'),
                        'icon' => 'fa fa-sitemap',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => ['/department/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Bank Holidays'),
                        'icon' => 'fa fa-plane',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => ['/bank-holiday/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Working Days'),
                        'icon' => 'fa fa-calendar',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => ['/working-day/index'],
                    ],
                ],
            ]);
            ?>
        </nav>
        <div class="menu-collapse-line">
            <!--Menu collapse/expand icon is put and control from LobiAdmin.js file-->
            <div class="menu-toggle-btn" data-action="collapse-expand-sidebar"></div>
        </div>
    </div>

    <div id="main">
        <div id="ribbon" class="hidden-print">
            <a href="<?php echo Url::to(['/']) ?>" class="btn-ribbon" data-container="#main" data-toggle="tooltip"
               data-title="Show dashboard"><i class="fa fa-home"></i></a>
            <?php echo Breadcrumbs::widget([
                'homeLink' => false,
                'tag' => 'ol',
                'encodeLabels' => false,
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div id="content">
            <?php if (Yii::$app->session->hasFlash('alert')): ?>
                <?php echo Alert::widget([
                    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                ]) ?>
            <?php endif; ?>

            <?php echo $content ?>
        </div>
    </div>
</div><!-- ./wrapper -->
<?php $this->registerJs("
var dropNot = $('.dropdown-notifications')
var notBody = dropNot.find('.notifications-body')
var lis = notBody.find('li')
lis.each(function(){
	$(this).click(function(){
		var that = $(this);
		location.href = that.data('url')
	})
})

") ?>
<?php $this->endContent(); ?>


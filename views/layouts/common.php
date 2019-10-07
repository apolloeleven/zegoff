<?php
/**
 * @var $this    yii\web\View
 * @var $content string
 */

use app\models\User;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;

$bundle = \app\assets\AppAsset::register($this);


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
                        <li><a href="<?php echo Url::to(['/timeline-event/index']) ?>"><i class="fa fa-code-fork"></i>
                                &nbsp;&nbsp;Timeline</a></li>
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
            <!--Choose languages dropdown-->
            <ul class="nav navbar-nav navbar-actions">
                <li>
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-danger badge-xs">
                                4
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-notifications dropdown-timeline notification-news border-1 animated-fast flipInX">
                        <div class="notifications-heading border-bottom-1 bg-white">
                            <?php echo Yii::t('app', 'Timeline') ?>
                        </div>
                        <ul class="notifications-body max-h-300">

                        </ul>
                        <div class="notifications-footer border-top-1 bg-white text-center">
                            <?php echo Html::a(Yii::t('app', 'View all'), ['/timeline-event/index']) ?>
                        </div>
                    </div>
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
                    <a href="<?php echo Url::to(['/user/index']) ?>" class="btn btn-info btn-outline"
                       data-title="Users">
                        <i class="fa fa-users"></i>
                    </a>
                    <a href="<?php echo Url::to(['/translation/default/index']) ?>" class="btn btn-info btn-outline"
                       data-title="Translations">
                        <i class="fa fa-language"></i>
                    </a>
                    <a href="<?php echo Url::to(['/system/cache/index']) ?>" class="btn btn-info btn-outline"
                       data-title="Cache">
                        <i class="fa fa-refresh"></i>
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
                        'label' => Yii::t('app', 'Employees'),
                        'icon' => 'fa fa-users',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => ['/user'],
                    ],
                    [
                        'label' => Yii::t('app', 'Department'),
                        'icon' => 'fa fa-users',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => ['/department'],
                    ],
                    [
                        'label' => Yii::t('app', 'Bank Holidays'),
                        'icon' => 'fa fa-users',
                        'visible' => Yii::$app->user->can(User::ROLE_MANAGER),
                        'url' => ['/bank-holiday'],
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
            <span class="vertical-devider">&nbsp;</span>
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

<?php $this->endContent(); ?>

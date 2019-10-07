<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'bundle/lobiadmin.css',
        'css/style.css',
        'css/bootstrap-tour.min.css',
    ];
    public $js = [
        'js/lobiplugins/lobibox.js',
        'js/highlight.pack.js',
        'js/ck-config.js',
        'js/config.js',
        'js/lobiadmin.js',
        'js/lobiadmin-app.js',
        'js/mark.js',
        'js/app.js',
        'js/bootstrap-tour.min.js',
        'js/lobiplugins/bootstrap-datepicker.js',
        'js/modal.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        FontAwesome::class,
        Html5shiv::class,
    ];
}

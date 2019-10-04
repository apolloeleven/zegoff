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
        'css/lobiadmin-with-plugins.css',
        'css/style.css',
        'css/bootstrap-tour.min.css',
    ];
    public $js = [
        'js/lobiplugins/lobibox.js',
        'js/config.js',
        'js/lobiadmin.js',
        'js/lobiadmin-app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        FontAwesome::class
    ];
}

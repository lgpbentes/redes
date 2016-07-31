<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/site.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        '//plugins/iCheck/flat/blue.css',
    ];
    public $js = [
        'js/app.min.js',
        'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

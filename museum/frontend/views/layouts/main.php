<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

$asset = AppAsset::register($this);
$baseUrl = $asset->baseUrl
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Fim de Papo</title>
    <link rel="icon" href="img/ico/coracao.png" type="image/x-icon" />
    <link rel="shortcut icon" href="img/ico/coracao.png" type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body class="fixed layout-top-nav skin-blue-light">
<!-- <body class = "sidebar-mini skin-blue-light"> -->
<?php $this->beginBody() ?>

<div class="wrapper">
    <?= $this->render('header.php',['baseUrl' => $baseUrl]) ?>
    <?= $this->render('leftmenu.php',['baseUrl' => $baseUrl]) ?>
    <?= $this->render('content.php',['content' => $content]) ?>

    <div class="control-sidebar-bg"></div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

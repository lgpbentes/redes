<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Moderador */

$this->title = 'Update Moderador: ' . $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Moderadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['view', 'id' => $model->login]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="moderador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

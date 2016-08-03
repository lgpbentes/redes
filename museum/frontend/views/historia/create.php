<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Historia */

$this->title = 'Contar minha História';
$this->params['breadcrumbs'][] = ['label' => 'Historias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

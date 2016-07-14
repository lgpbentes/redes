<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\HistoriaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'autor') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'imagem') ?>

    <?= $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'qteGostei') ?>

    <?php // echo $form->field($model, 'qteNaoGostei') ?>

    <?php // echo $form->field($model, 'qteDenuncias') ?>

    <?php // echo $form->field($model, 'duracao') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'moderador') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

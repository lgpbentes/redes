<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = 'Cadastrar Usuário';
?>
<div class="col-lg-3"></div>
<div class="col-lg-6">
    <div class="site-signup">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="box box-primary">
            <div class="box-header with-border">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <!--<?= $form->field($model, 'dataNascimento') ?>-->

                <label class="control-label">Data de nascimento:</label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'dataNascimento',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
                <?= $form->field($model, 'cidade') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <label class="control-label">Confirme a senha:</label>
                <input type="password" class="form-control">

                <br>
                <div class="form-group">
                    <?= Html::submitButton('Cadastrar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
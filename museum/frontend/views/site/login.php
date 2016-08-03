<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<div class="col-lg-4"></div>
<div class="col-lg-4">
    <div class="site-login">

        <div class="box box-primary">
            <div class="box-header with-border">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <br>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    <br>
                    <p align="right">Não é um membro? <a href="/redes/museum/frontend/web/index.php?r=site/signup" style="color: #3c8dbc"><b>Cadastre-se</b></a></p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

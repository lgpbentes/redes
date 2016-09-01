<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bupy7\cropbox\Cropbox;

/* @var $this yii\web\View */
/* @var $model frontend\models\Historia */
/* @var $form yii\widgets\ActiveForm */


?>
<div class="historia-form">
    <div class="box box-primary">
        <div class="box-header with-border">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($model, 'autor')->hiddenInput(['value' => Yii::$app->user->identity->getId()])->label('')?>
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>


    <?=$form->field($model, 'imagem')->widget(Cropbox::className(), [
    'attributeCropInfo' => 'crop_info']) ?>


    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'duracao')->hiddenInput()?>

    <!--<?= $form->field($model, 'duracao')->textInput() ?>-->

    <label class="control-label">Ano(s)</label>
    <select id="anos" class="form-control" style="width:100px" onchange="calculaDuracao()">
        <option value="0">0</option>
        <option value="1">1 ano</option>

        <script>
            for (var i = 2; i < 100; i++){
                document.write("<option value="+ i + ">"+i +" anos</option>");
            }
        </script>
    </select>

    <label class="control-label">Mes(es)</label>
    <select id="meses" class="form-control" style="width:100px" onchange="calculaDuracao()">
        <option value="0">0</option>
        <option value="1">1 mês</option>

        <script>
            for (var i = 2; i <= 11; i++){
                document.write("<option value="+ i + ">"+i +" meses</option>");
            }
        </script>
    </select>

    <label class="control-label">Dia(s)</label>
    <select id="dias" class="form-control" style="width:100px" onchange="calculaDuracao()">
        <option value="0">0</option>
        <option value="1">1 dia</option>

        <script>
            for (var i = 2; i <=30; i++){
                document.write("<option value="+ i + ">"+i +" dias</option>");
            }
        </script>
    </select>

    <script>
        function calculaDuracao(e) {
            var anos = document.getElementById("anos").value;
            var meses = document.getElementById("meses").value;
            var dias = document.getElementById("dias").value;
            var durac = document.getElementById("historia-duracao");

            durac.value = (anos * 365) + (meses * 30) + (dias*1);
        }
        
    </script>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
        </div>
</div>
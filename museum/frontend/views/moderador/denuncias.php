<?php
/**
 * Created by PhpStorm.
 * User: lgpbentes
 * Date: 15/09/16
 * Time: 09:50
 */

use frontend\models\Historia;
use common\models\User;
use app\models\UsuarioDenunciaHistoria;
use frontend\models\Moderador;

/* @var $this yii\web\View */

$this->title = 'Museum';
?>
<div class="site-index">

    <!-- Box Header -->
    <?php
    //procura pelas história denunciadas que AINDA nao foram removidas
    $denunciadas = Historia::find()->where(['>', 'qteDenuncias', 0])->all();
    foreach ($denunciadas as $id => $hist){
        $numHistoria = $hist->id;
        //procura pelo username do autor da postagem
        $autor = User::findOne($hist->autor)->username;
        $caminhoImagem= "/redes/museum/".$hist->imagem;
        $tempo = $hist->duracao;
        $titulo = $hist->nome;
        $qteViews = $hist->qteViews;
        $qteLikes = $hist->qteGostei;
        $qteDeslikes = $hist->qteNaoGostei;
        $qteDenuncias = $hist->qteDenuncias;
        $descricao = $hist->descricao;
        $moderador= Moderador::findOne($hist->moderador);
        if($moderador){
            $moderador = $moderador->login;
        }else{
            $moderador = "nao sei";
        }

        ?>
        <div class="col-md-12">
            <div class="box box-widget">
                <div class="box-header with-border">

                    <div class="user-block">
                        <img class="img-circle" src="img/perfiltmp.png" alt="Imagem do usuário">
                        <span class="username"><a href="#"><?=$autor?></a></span>
                        <span class="description">Tempo do relacionamento: <?= $tempo ?> dias</span>
                        <span class="description">Moderador que aprovou: <?= $moderador ?></span>

                    </div>

                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>

                </div>

                <!-- box-body -->
                <div class="box-body" style="display: block;">
                    <img class="img-responsive pad" src="<?= $caminhoImagem ?>" alt="Photo">
                    <p><?=$titulo?></p>
                    <p><?=$descricao?></p>

                    <button onclick="aceitarDenuncia(<?= $numHistoria ?>)" type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i>Aceitar denúncia</button>

                    <span class="pull-right text-muted"><?=$qteViews?> views -  <?=$qteLikes?> likes - <?= $qteDeslikes ?> dislikes - <?=$qteDenuncias ?> denuncias</span>

                </div><!-- /.box-body -->

            </div>
        </div>
        <?php
    }

    ?>
</div>

<script>

    function aceitarDenuncia(id) {
        $.get('index.php?r=site/reprovacao&id='+id,function (dados) {
            console.log(dados);
            location.reload();
        });
    }


</script>

<?php
/**
 * Created by PhpStorm.
 * User: lgpbentes
 * Date: 15/09/16
 * Time: 21:49
 */

use frontend\models\Historia;
use common\models\User;
use yii\widgets\Pjax;
use app\models\UsuarioComentaHistoria;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Museum';
date_default_timezone_set('America/Manaus');
?>
<div class="site-index">


    <!-- LARISSA BENTES -->
    <!-- Modal -->
    <div class="modal fade" id="MoreInfoModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="reload()" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="detalheTitulo" class="modal-title">Título da foto</h4>
                </div>
                <div class="modal-body">
                    <p id="detalheHistoria">História do Objeto</p>
                </div>
                <div class="modal-footer">
                    <div align="left">
                        <!--<button id='likeHistoria' onclick="like()" type="button" class="btn btn-success btn-sm"><i class="fa fa-thumbs-up"></i> </button>-->
                        <!--<button id= 'deslikeHistoria' onclick="deslike()" type="button" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-down"></i> </button>-->
                        <span id="reacaoHistoria"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Box Header -->
    <?php
    $atual = Yii::$app->user->identity->getId();
    $historias = Historia::find()->where(['autor'=> $atual])->all();
    foreach ($historias as $hist) {
        $numHistoria = $hist->id;

        $caminhoImagem = "/redes/museum/" . $hist->imagem;
        $tempo = $hist->duracao;
        $titulo = $hist->nome;
        $qteViews = $hist->qteViews;
        $qteLikes = $hist->qteGostei;
        $qteDeslikes = $hist->qteNaoGostei;
        $dataPublicacao = $hist->dataPublicacao;
        $dataPublicacao = date('d-m-Y', strtotime($dataPublicacao));
        $comentarios = UsuarioComentaHistoria::find()->where(['historia' => $numHistoria])->all();
        if ($hist->status == 0){
            $hist->status = "Aguardando aprovação";
        } else if ($hist->status == 1){
            $hist->status = "Publicada";
        } else{
            $hist->status = "Não aceita/Removida";
        }
            ?>
            <div class="col-md-4" id='<?= $numHistoria ?>'>
                <div class="box box-widget">
                    <div class="box-header with-border">

                        <div class="user-block">
                            <img class="img-circle" src="img/perfiltmp.png" alt="Imagem do usuário">
                            <span class="username"><a href="#"><?= $hist->status ?></a></span>
                            <span class="description">Tempo do relacionamento: <?= $tempo ?> dias</span>
                            <span class="description">Postado em: <?= $dataPublicacao ?> </span>

                        </div>

                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>

                    </div>

                    <!-- box-body -->
                    <div class="box-body" style="display: block;">

                        <img src="<?= $caminhoImagem ?>" alt="Photo" height="300" width="370">

                        <p><?= $titulo ?></p>
                        <button onclick="detalhar(<?= $numHistoria ?>)" type="button" class="btn btn-info btn-xs"
                                data-toggle="modal" data-target="#MoreInfoModal" data-backdrop="static"><i
                                class="fa fa-eye"></i></button>
                        <?= Html::a('', ['delete', 'id' => $numHistoria], [
                            'class' => 'btn btn-danger glyphicon glyphicon-trash btn-xs',
                            'data' => [
                                'confirm' => 'Tem certeza que deseja excluir esse item?',
                                'method' => 'post',
                            ],
                        ]) ?>

                        <span class="pull-right text-muted"><?= $qteViews ?> views - <?= $qteLikes ?>
                            likes - <?= $qteDeslikes ?> dislikes</span>
                    </div><!-- /.box-body -->

                    <?php
                    foreach ($comentarios as $historia => $comentario) {
                        $autorComentario = User::findOne($comentario->usuario)->username;
                        $conteudoComentario = $comentario->comentario;
                        $horaComentario = $comentario->horario;
                        $horaComentario = date('d-m-Y h:i a', strtotime($horaComentario));
                        ?>
                        <!-- box comments -->
                        <div class="box-footer box-comments">
                            <div class="box-comment">
                                <!-- Foto do Usuário -->
                                <img class="img-circle img-sm" src="img/perfiltmp.png" alt="user image">
                                <div class="comment-text">
                            <span class="username">
                                <?= $autorComentario ?>
                                <span class="text-muted pull-right"><?= $horaComentario ?></span>
                            </span><!-- /.username -->
                                    <?= $conteudoComentario ?>
                                </div><!-- /.comment-text -->
                            </div><!-- /.box-comment -->
                        </div><!-- /.box-footer -->
                        <?php
                    }
                    ?>
                </div>
            </div>


            <?php

    }
    ?>
</div>

<script>
    function comentar(cm) {
        if(event.keyCode == 13) {
            comment = cm.value;
            id3 =  cm.id.substring(2);

            $.get('index.php?r=site/comentar&idHistoria='+id3+'&comentario='+comment,function (dados) {
                cm.value = "";
                reload();

            });
        }
    }

    var historiaclicada;

    function denunciar(botaoDenunciar) {
        id2 = botaoDenunciar.id.substring(9);
        $.get('index.php?r=site/denuncie&idHistoria='+id2,function (dados) {
            //console.log(dados);
            botaoDenunciar.style.backgroundColor = "grey";
        });

    }

    function salvar(botaoSalvar) {
        id6 = botaoSalvar.id.substring(6);
        $.get('index.php?r=site/salvar&idHistoria='+id6,function (dados) {
            //console.log(dados);
            botaoSalvar.style.backgroundColor = "green";
        });

    }

    function detalhar(id) {
        historiaclicada = id;
        var titulo, descricao, reacaoDeslike, reacaoLike, reacaoHistoria;
        titulo = document.querySelector("#detalheTitulo");
        descricao = document.querySelector("#detalheHistoria");
        reacaoDeslike = document.querySelector("#deslikeHistoria");
        reacaoLike = document.querySelector("#likeHistoria");
        reacaoHistoria = document.querySelector("#reacaoHistoria");


        $.get('index.php?r=site/detalhes&id='+id,function (dados) {
            console.log(dados);
            dados = JSON.parse(dados);

            titulo.innerHTML = dados.titulo;
            descricao.innerHTML= dados.descricao;
            if(dados.reacao == 1){
                reacaoDeslike.style.backgroundColor = "rgba(0, 0, 0, 0.3)";
                reacaoHistoria.innerHTML = "  Você deu um like nessa história";
            } else if (dados.reacao == 2){
                reacaoLike.style.backgroundColor = "rgba(0, 0, 0, 0.3)";
                reacaoHistoria.innerHTML = "  Você deu um deslike nessa história";

            }

        });
    }

    function like_old() {
        $.get('index.php?r=site/like&id='+historiaclicada,function (dados) {
            var  reacaoDeslike, reacaoHistoria;

            reacaoDeslike = document.querySelector("#deslikeHistoria");
            reacaoHistoria = document.querySelector("#reacaoHistoria");

            reacaoDeslike.style.backgroundColor = "rgba(0, 0, 0, 0.3)";
            reacaoHistoria.innerHTML = "  Você deu um like nessa história";
        });
    }

    function like(botaoLike) {
        id4 = botaoLike.id.substring(4);
        $.get('index.php?r=site/like&id='+id4,function (dados) {
            botaoLike.style.backgroundColor = "rgba(0, 0, 0, 0.7)";

        });
    }

    function deslike_old() {
        $.get('index.php?r=site/deslike&id='+historiaclicada,function (dados) {
            var reacaoLike, reacaoHistoria;

            reacaoLike = document.querySelector("#likeHistoria");
            reacaoHistoria = document.querySelector("#reacaoHistoria");

            reacaoLike.style.backgroundColor = "rgba(0, 0, 0, 0.3)";
            reacaoHistoria.innerHTML = "  Você deu um deslike nessa história";
        });
    }
    function deslike(botaoDeslike) {
        id5 = botaoDeslike.id.substring(7);
        $.get('index.php?r=site/deslike&id='+id5,function (dados) {
            botaoDeslike.style.backgroundColor = "rgba(0, 0, 0, 0.7)";

        });

    }

</script>

<script>
    function reload() {
        location.reload();
    }
</script>
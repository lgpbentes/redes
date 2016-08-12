<?php
use frontend\models\Historia;
use common\models\User;

/* @var $this yii\web\View */

$this->title = 'Museum';
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
                            <button onclick="like()" type="button" class="btn btn-success btn-sm"><i class="fa fa-thumbs-up"></i> </button>
                            <button onclick="deslike()" type="button" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-down"></i> </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Box Header -->
        <?php
        $historias = Historia::find()->all();
        foreach ($historias as $id => $hist){
            //var_dump($hist);

            $numHistoria = $hist->id;
            //procura pelo username do autor da postagem
            $autor = User::findOne($hist->autor)->username;
            $caminhoImagem= "/redes/museum/".$hist->imagem;
            $tempo = $hist->duracao;
            $titulo = $hist->nome;
            $qteViews = $hist->qteViews;
            $qteLikes = $hist->qteGostei;
            $qteDeslikes = $hist->qteNaoGostei;

            if($hist->status == 1){


            ?>
        <div class="col-md-4">
            <div class="box box-widget">
                <div class="box-header with-border">

                    <div class="user-block">
                        <img class="img-circle" src="img/perfiltmp.png" alt="Imagem do usuário">
                        <span class="username"><a href="#"><?=$autor?></a></span>
                        <span class="description">Tempo do relacionamento: <?= $tempo ?> dias</span>
                    </div>

                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>

                </div>

                <!-- box-body -->
                <div class="box-body" style="display: block;">
                    <img class="img-responsive pad" src="<?= $caminhoImagem ?>" alt="Photo">
                    <p><?=$titulo?></p>
                    <button onclick="detalhar(<?=$numHistoria?>)" type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#MoreInfoModal" data-backdrop="static"><i class="fa fa-eye"></i> Saber mais</button>
                    <span class="pull-right text-muted"><?=$qteViews?> views -  <?=$qteLikes?> likes - <?= $qteDeslikes ?> dislikes</span>

                </div><!-- /.box-body -->

            </div>
        </div>
                <?php
        }
        }
        ?>
</div>

<script>
    var historiaclicada;
    function detalhar(id) {
        historiaclicada = id;
        var titulo, descricao;
        titulo = document.querySelector("#detalheTitulo");
        descricao = document.querySelector("#detalheHistoria");


        $.get('index.php?r=site/detalhes&id='+id,function (dados) {
            dados = JSON.parse(dados);

            titulo.innerHTML = dados.titulo;
            descricao.innerHTML= dados.descricao;

        });
    }

    function like() {
        $.get('index.php?r=site/like&id='+historiaclicada,function (dados) {
            console.log("rolou? "+ dados);
        });
    }

    function deslike() {
        $.get('index.php?r=site/deslike&id='+historiaclicada,function (dados) {
        });
    }

</script>

<script>
    function reload() {
        location.reload();
    }
</script>
<?php
use frontend\models\Historia;
use common\models\User;

/* @var $this yii\web\View */

$this->title = 'Museum';
?>
<div class="site-index">



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
        $descricao = $hist->descricao;

        if($hist->status == 0){
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
                        <p><?=$descricao?></p>

                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> </button>

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
        $.get('index.php?r=site/like&id='+historiaclicada,function (dados) {});
    }

    function deslike() {
        $.get('index.php?r=site/deslike&id='+historiaclicada,function (dados) {
        });
    }

</script>
<?php

/* @var $this yii\web\View */

$this->title = 'Museum';
?>
<div class="site-index">


    <!-- LARISSA BENTES -->
    <div class="col-md-6">


        <!-- Modal -->
        <div class="modal fade" id="MoreInfoModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Título da foto</h4>
                    </div>
                    <div class="modal-body">
                        <p>História do Objeto</p>
                    </div>
                    <div class="modal-footer">
                        <div align="left">
                            <button type="button" class="btn btn-success btn-sm"><i class="fa fa-thumbs-up"></i> </button>
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-down"></i> </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Box Header -->
        <div class="box box-widget">
            <div class="box-header with-border">

                <div class="user-block">
                    <img class="img-circle" src="photo2.png" alt="Imagem do usuário">
                    <span class="username"><a href="#">Nome do Usuário - Ou Privado</a></span>
                    <span class="description">Tempo do relacionamento: X dias</span>
                </div>

                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>

            </div>

            <!-- box-body -->
            <div class="box-body" style="display: block;">
                <img class="img-responsive pad" src="user3-128x128.jpg" alt="Photo">
                <p>Título da foto</p>
                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#MoreInfoModal" data-backdrop="static"><i class="fa fa-eye"></i> Saber mais</button>
                <span class="pull-right text-muted">3 views - 100 likes - 127 dislikes</span>
            </div><!-- /.box-body -->

        </div>
    </div>

</div>

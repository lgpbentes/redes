<?php
use yii\widgets\Breadcrumbs;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </section>

    <!-- Main Content -->
    <section class="content" style="width:550px; overflow:auto">
        <?= $content ?>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
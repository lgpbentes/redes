<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HistoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Historia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'autor',
            'nome',
            'imagem:ntext',
            'descricao:ntext',
            // 'qteGostei',
            // 'qteNaoGostei',
            // 'qteDenuncias',
            // 'duracao',
            // 'status',
            // 'moderador',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

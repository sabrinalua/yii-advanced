<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;

?>
<h1>user/index</h1>

<p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showOnEmpty'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'fname',
            'lname',
            'email',
            ['class' => 'yii\grid\ActionColumn','template'=>'{update}{view}',],
        ],
    ]); ?>

</p>

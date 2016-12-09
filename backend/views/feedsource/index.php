<?php

use yii\helpers\Html;
use yii\helpers\BaseHtml;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedSourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feed Sources';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feed-source-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Feed Source', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'link',
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter'=>array("active"=>"active","inactive"=>"inactive"),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}{import}',
                'buttons'=>[
                    'import'=>function($url, $model,$key){
                        return Html::a('<img width=25 height=25 src ='.Yii::$app->request->baseUrl.'/images/down2.jpg'.'>', ['import', 'id'=>$model->id]);
                    },
                ],
                ],
        ],
    ]); ?>
</div>

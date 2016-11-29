<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;

//@var $model User
//$var $this UserController

?>

<?= GridView::widget([
    'dataProvider' => $model,
    'columns' => [
    	'id',
        'fname',
        'lname',
        'username',
        'email',
        [
	        'class'=>'yii\grid\ActionColumn',
	        'template'=>'{view}{update}{delete}',
        ],
        // ...
    ],
]) ?>
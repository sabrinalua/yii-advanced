<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FeedSource */

$this->title = 'Update Feed Source: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Feed Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="feed-source-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

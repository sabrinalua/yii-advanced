<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FeedSource */

$this->title = 'Create Feed Source';
$this->params['breadcrumbs'][] = ['label' => 'Feed Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feed-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

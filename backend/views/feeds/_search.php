<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeedsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feeds-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'source_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'summary') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'img_link') ?>

    <?php // echo $form->field($model, 'img_name') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

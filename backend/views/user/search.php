<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="user-search">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'fname') ?>
        <?= $form->field($model, 'lname') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'username') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-search -->

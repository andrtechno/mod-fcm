<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use yii\web\View;

/**
 * @var \panix\engine\bootstrap\ActiveForm $form
 * @var \panix\mod\fcm\models\SettingsForm $model
 */

$form = ActiveForm::begin(['id' => 'fcm-form']);
?>


<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'server_key'); ?>
        <?= $form->field($model, 'sender_id'); ?>
    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

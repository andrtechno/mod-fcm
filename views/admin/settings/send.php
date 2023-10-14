<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use yii\web\View;

/**
 * @var \panix\engine\bootstrap\ActiveForm $form
 * @var \panix\mod\fcm\models\NotificationForm $model
 */

$form = ActiveForm::begin(['id' => 'notification-form']);

?>

<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'device_id'); ?>
        <?= $form->field($model, 'title'); ?>
        <?= $form->field($model, 'body')->textarea(); ?>
    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app/default', 'SEND'), ['class' => 'btn btn-success']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

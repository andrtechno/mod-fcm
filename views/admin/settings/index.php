<?php

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

        <?php
        echo $form->field($model, 'tokens')->widget(\panix\ext\multipleinput\MultipleInput::className(), [
            'max' => 10,
            'allowEmptyList' => false,
            'enableGuessTitle' => true,
            'addButtonPosition' => \panix\ext\multipleinput\MultipleInput::POS_ROW, // show add button in the header
        ])->label(false);
        ?>
    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

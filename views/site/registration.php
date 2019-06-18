<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="text-left">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($RegMessage) { ?>
        <?= $RegMessage ?>
    <?php } else { ?>
		
		<p>Заполните следующие поля для регистрации:</p>
		
    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
				
				<?= $form->field($model, 'name')->
            textInput(['autofocus' => true])->
            label('Имя') ?>
				
        <?= $form->field($model, 'email')->
            textInput(['autofocus' => true, 'placeholder' => 'name@email.com'])->
            label('E-mail') ?>

        <?= $form->field($model, 'password')->
        passwordInput()->label('Пароль') ?>

        <?= $form->field($model, 'repassword')->
        passwordInput()->label('Повторите пароль') ?>

				<div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <?php } ?>
</div>

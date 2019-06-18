<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id'           => 'project-form',
    'options'      => ['class' => 'form-horizontal'],
    'fieldConfig'  => [
        'template'     => "<div class=\"col-lg-4\"></div><div class=\"col-lg-4 text-center\">{label}:{input}<div>{error}</div></div><div class=\"col-lg-4\"></div>",
        'labelOptions' => ['class' => ' control-label']
    ]
]);
?>

<h3>Новый проект</h3>

<?= $form->field($model, 'name')->textInput(['autofocus' => true])->label("Название проекта");?>

<div class="form-group">
    <div class="col-lg-12 text-center">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
        <a href="<?= Url::to(['/']) ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
    </div>
</div>

<?php ActiveForm::end();

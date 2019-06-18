<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id'          => 'theme-form',
    'options'     => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template'     => "<div class=\"col-lg-4\"></div><div class=\"col-lg-4 text-center\">{label}:{input}<div>{error}</div></div><div class=\"col-lg-4\"></div>",
        'labelOptions' => ['class' => ' control-label'],
    ],
]); ?>

<?= $form->field($model, 'name')->textInput(['autofocus' => true])->label("Задание"); ?>
<?= $form->field($model, 'status_id')->dropdownList($status)->label("Статус"); ?>
<div class="form-group">
    <div class="col-lg-12 text-center">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
        <a href="<?= Url::to(['project/' . $task['project_id']]) ?>" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Отмена</a>
    </div>
</div>

<?php ActiveForm::end(); ?>
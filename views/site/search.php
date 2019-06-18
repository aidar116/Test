<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;

$this->title = 'Поиск задач';
?>
<?php 
$form = ActiveForm::begin([
    'id'          => 'letters-form',
    'options'     => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template'     => "<div class=\"col-lg-4\"></div><div class=\"col-lg-4 text-center\">{label}:{input}<div>{error}</div></div><div class=\"col-lg-4\"></div>",
        'labelOptions' => ['class' => ' control-label']
    ]
]);
?>
<?= $form->field($model, 'name')->textInput(['autofocus' => true])->label("Поиск задачи по названию") ?>
<?= $form->field($model, 'status')->dropdownList($status)->label("Статус"); ?>
<div class="form-group">
    <div class="col-lg-12 text-center">
        <?= Html::submitButton("Найти", [
            'class' => 'btn btn-primary',
            'name' => 'add-button']) 
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php if (isset($_REQUEST['add-button']) && $result) { ?>
<table class="table">
    <tr>
        <th>Проект</th>
        <th>Название</th>
        <th>Автор</th>
        <th>Статус</th>
	<?php foreach ($result AS $oneTask) { ?>
    <tr>
        <td><?= Html::encode($oneTask['project']) ?></td>
        <td><?= Html::encode($oneTask['name']) ?></td>
        <td><?= Html::encode($oneTask['user']) ?></td>
        <td><?= Html::encode($oneTask['status']) ?></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
<?php if (isset($_REQUEST['add-button']) && $result == false) { ?>
	<div class="alert alert-warning" role="alert"><?= $InfoMessage ?></div>
<?php } ?>

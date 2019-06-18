<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = 'TestSite';
?>
<?php $this->params['breadcrumbs'][] = ['label' => $project['name']]; ?>
<?php if (Yii::$app->user->isGuest): ?>
<?php else: ?>
	<p><a class="btn btn-success" href="<?= Url::to(['/task/new/' . $project['id']]) ?>">Создать новую задачу</a></p>
<?php endif; ?>

<?php if ($TaskMessage) { ?>
    <div class="alert alert-success" role="alert"><?= $TaskMessage ?></div>
<?php } ?>
<table class="table">
    <tr>
        <th>Название</th>
        <th>Автор</th>
        <th>Статус</th>
        <th>Редактирование</th>
	<?php foreach ($tasks AS $oneTask) { ?>
    <tr>
        <td><?= Html::encode($oneTask['name']) ?></td>
        <td><?= Html::encode($oneTask['user']) ?></td>
        <td><?= Html::encode($oneTask['status']) ?></td>
        <td>
            <a class="btn btn-primary" href="<?= Url::to(['/task/edit/' . $oneTask['id']]) ?>">Редактировать</a>
            <a class="btn btn-danger" href="<?= Url::to(['/task/delete/' . $oneTask['id']]) ?>">Удалить</a>
        </td>
	</tr>
	<?php } ?>
</table>
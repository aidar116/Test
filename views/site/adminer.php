<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = 'TestSite';
?>
<?php $this->params['breadcrumbs'][] = ['label' => 'adminer']; ?>
<?php if (Yii::$app->user->isGuest): ?>
<?php else: ?>
<?php if ($AdminerMessage) { ?>
    <div class="alert alert-success" role="alert"><?= $AdminerMessage ?></div>
<?php } ?>
<table class="table">
    <tr>
        <th>Имя</th>
        <th>Email</th>
        <th>Редактирование</th>
	<?php foreach ($users AS $oneUser) { ?>
    <tr>
        <td><?= Html::encode($oneUser['name']) ?></td>
        <td><?= Html::encode($oneUser['email']) ?></td>
        <td>
            <a class="btn btn-warning" href="<?= Url::to(['/user/ban/' . $oneUser['id']]) ?>">Бан</a>
            <a class="btn btn-danger" href="<?= Url::to(['/user/delete/'  . $oneUser['id']]) ?>">Удалить</a>
        </td>
	</tr>
	<?php } ?>
</table>
<?php endif; ?>
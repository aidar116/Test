<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'TestSite';
?>

<h2>Welcome to TestSite</h2>

<?php if (Yii::$app->user->isGuest): ?>
<?php else: ?>
	<?php if (Yii::$app->user->identity->group_id === 1): ?>
		<p><a class="btn btn-success" href="<?= Url::to(['/project/new']) ?>">Новый проект</a></p>
	<?php else: ?>
	<?php endif; ?>
<?php endif; ?>

<?php if ($ProjectMessage) { ?>
    <div class="alert alert-success" role="alert"><?= $ProjectMessage ?></div>
<?php } ?>

<ul class="nav nav-pills nav-stacked">
<?php foreach ($project AS $oneProject) { ?>
    <li>
    <?php if (Yii::$app->user->isGuest): ?>
        <?= Html::encode("{$oneProject->name}") ?>
    </li>
    <?php else: ?>
        <a href="/project/<?= Html::encode("{$oneProject->id}") ?>"><?= Html::encode("{$oneProject->name}") ?></a>
    </li>
        <?php if (Yii::$app->user->identity->group_id === 1): ?>
            <p><a class="text-success" href="<?= Url::to(['/project/edit/'.$oneProject->id]) ?>">Редактировать</a>
            <a class="text-danger" href="<?= Url::to(['/project/delete/'.$oneProject->id]) ?>">Удалить</a></p><hr>
        <?php else: ?>
        <?php endif; ?>
    <?php endif; ?>
<?php } ?>
</ul>
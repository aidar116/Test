<?php

namespace app\components;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\base\ActionFilter;

class AdminControl extends ActionFilter
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest)
            throw new ForbiddenHttpException("Необходимо авторизоваться!");
        else if (!Yii::$app->user->identity->group_id)
            throw new ForbiddenHttpException("У вас нет прав администратора!");
        
        return true;
    }
}

?>
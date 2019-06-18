<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function findIdentity($id)
    {
        $user = self::findOne($id);
        return $user;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['authkey' => $token]);
    }

    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }
		
		public static function findByName($name)
    {
        return self::findOne(['name' => $name]);
    }

    public function getId()
    {
        return $this->id;
    }
		
    public function getAuthKey()
    {
        return $this->authkey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}

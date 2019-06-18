<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $name, $email, $password, $repassword;

    public function rules()
    {
        return [
            [
                'name',
                'required',
                'message' => 'Введите имя!'
            ],
            [
                'name',
                'unique',
                'targetClass' => User::className(),
                'message' => 'Пользователь с таким именем уже зарегистрирован!'
            ],
            [
                'email',
                'required',
                'message' => 'Введите E-mail!'
            ],
            [
                'email',
                'email',
                'message' => 'Некорректный E-mail!'
            ],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message' => 'Пользователь с таким Email уже зарегистрирован!'
            ],
            [
                'password',
                'required',
                'message' => 'Введите пароль!'
            ],
            [
                'repassword',
                'required',
                'message' => 'Повторите ввод пароля!'
            ],
            [
                'password',
                'string',
                'min' => 6,
                'message' => 'Пароль должен содержать не менее 6-и символов!'
            ],
            [
                'repassword',
                'validateRepassword'
            ]
        ];
    }

    public function validateRepassword($attribute, $params)
    {
        if ($this->password != $this->repassword)
            $this->addError($attribute, 'Пароли не совпадают!');
    }

    public function registration()
    {
        if ($this->validate()) {

            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->authkey = Yii::$app->security->generatePasswordHash($user->email);
            $user->save();

            return true;
        }

        return false;
    }
}

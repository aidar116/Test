<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                'email',
                'required',
                'message' => 'Введите E-mail!'
            ],
            // username and password are both required
            [
                'password',
                'required',
                'message' => 'Введите пароль!'
            ],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['email', 'validateUser']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password))
                $this->addError($attribute, 'Некорректный логин или пароль!');
        }
    }
    
    public function validateUser($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if ($user->status)
                $this->addError($attribute, 'Пользователь забанен!');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false)
            $this->_user = User::findByEmail($this->email);
        
        return $this->_user;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

class RegisterForm extends Model
{
    public $full_name;
    public $login;
    public $password;
    public $phone;
    public $rule;
    public $birthday;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['full_name', 'login', 'password', 'phone', 'birthday'], 'required'],
            [['full_name', 'login', 'password', 'phone'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 8],
            [['login'], 'string', 'min' => 6],


            // ФИО: кириллица + пробелы, минимум 2 пробела (Ф И О)
            ['full_name', 'match', 'pattern' => '/^[а-яё]+\s[а-яё]+\s([а-яё\s]+)$/iu', 'message' => 'ФИО должно содержать символы кириллицы и не менее 2-ух пробелов'],

            // Телефон: формат 8(XXX)XXX-XX-XX
            ['phone', 'match', 'pattern' => '/^8\([\d]{3}\)[\d]{3}(\-[\d]{2}){2}$/', 'message' => 'Телефон должен быть в формате 8(XXX)XXX-XX-XX'],

            // Логин: латиница + цифры, минимум 6 символов, есть хотя бы одна заглавная и строчная буква + цифра
            ['login', 'match', 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d])[a-zA-Z\d]+$/', 'message' => 'Логин должен содержать латинские буквы (верхний/нижний регистр) и цифры, минимум 6 символов'],
            ['login', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят'],

            // Пароль: аналогично логину
            ['password', 'match', 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d])[a-zA-Z\d]+$/', 'message' => 'Пароль должен содержать латинские буквы (верхний/нижний регистр) и цифры'],

            // Дата рождения
            ['birthday', 'date', 'format' => 'php:Y-m-d', 'message' => 'Дата рождения должна быть в формате ГГГГ-ММ-ДД'],
            ['birthday', 'compare', 'compareValue' => date('Y-m-d', strtotime('-18 years')), 'operator' => '<=', 'message' => 'Вы должны быть старше 18 лет'],

            // Согласие
            ['rule', 'boolean'],
            ['rule', 'required', 'requiredValue' => 1, 'message' => 'Необходимо согласиться с обработкой персональных данных'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
            'login' => 'Логин',
            'password' => 'Пароль',
            'phone' => 'Телефон',
            'rule' => 'Согласие с обработкой персональных данных',
            'birthday' => 'Дата рождения',
        ];
    }

    public function userRegister(): bool|object
    {
        if ($this->validate()) {
            $user = new User();
            $user->attributes = $this->attributes;
            $user->role_id = \app\models\Role::getRoleId('user');
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();

            if (! $user->save()) {
                Yii::debug($user->errors);
                return false;
            }
              return $user;
        }

        return false;
    }
}

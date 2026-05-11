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
            [['full_name', 'login', 'password', 'phone', 'birthday', 'rule'], 'required'],
            [['full_name', 'login', 'password', 'phone'], 'string', 'max' => 255],

            [
                'full_name',
                'match',
                'pattern' => '/^[а-яёА-ЯЁ-]+(\s[а-яёА-ЯЁ-]+){1,}$/u',
                'message' => 'ФИО должно содержать только буквы кириллицы, дефис и пробелы. Обязательно минимум один пробел. Не допускается несколько пробелов подряд.'
            ],
            [
                'phone',
                'match',
                'pattern' => '/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
                'message' => 'Телефон должен быть в формате 8(XXX)XXX-XX-XX'
            ],

            // Логин: латиница + цифры, мин 6 символов, хотя бы 1 заглавная, 1 строчная, 1 цифра
            ['login', 'string', 'min' => 6],
            [
                'login',
                'match',
                'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,}$/',
                'message' => 'Логин должен содержать только латинские буквы (верхний/нижний регистр) и цифры, минимум 6 символов'
            ],
            ['login', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят'],

            // Пароль: аналогично логину, мин 8 символов
            ['password', 'string', 'min' => 8],
            [
                'password',
                'match',
                'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/',
                'message' => 'Пароль должен содержать только латинские буквы (верхний/нижний регистр) и цифры, минимум 8 символов'
            ],

            // Телефон уникален
            ['phone', 'unique', 'targetClass' => User::class, 'message' => 'Этот телефон уже занят'],

// Дата рождения
['birthday', 'date', 'format' => 'php:d.m.Y', 'message' => 'Дата рождения должна быть в формате ДД.ММ.ГГГГ'],
['birthday', 'validateAge'], // кастомный валидатор

            // Согласие
            ['rule', 'boolean'],
            [
                'rule',
                'compare',
                'compareValue' => '1',
                'message' => 'Необходимо согласиться с обработкой персональных данных'
            ],
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

    public function validateAge($attribute)
{
    if (!empty($this->$attribute)) {
        $birthday = \DateTime::createFromFormat('d.m.Y', $this->$attribute);
        if ($birthday) {
            $age = $birthday->diff(new \DateTime())->y;
            if ($age < 14) {
                $this->addError($attribute, 'Вы должны быть старше 14 лет');
            }
        }
    }
}
}

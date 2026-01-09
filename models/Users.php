<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $phone
 * @property string $birthday
 * @property int $gender_id
 * @property int $role_id
 * @property string $auth_key
 *
 * @property Baskets[] $baskets
 * @property Baskets[] $baskets0
 * @property Genders $gender
 * @property Order[] $orders
 * @property Roles $role
 * @property Subscribe[] $subscribes
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'phone', 'birthday', 'gender_id', 'auth_key'], 'required'],
            [['birthday'], 'safe'],
            [['gender_id', 'role_id'], 'integer'],
            [['login', 'auth_key'], 'string', 'max' => 255],
            [['password', 'phone'], 'string', 'max' => 100],
            [['login'], 'unique'],
            [['phone'], 'unique'],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genders::class, 'targetAttribute' => ['gender_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'phone' => 'Phone',
            'birthday' => 'Birthday',
            'gender_id' => 'Gender ID',
            'role_id' => 'Role ID',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * Gets query for [[Baskets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBaskets()
    {
        return $this->hasMany(Baskets::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Baskets0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBaskets0()
    {
        return $this->hasMany(Baskets::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Genders::class, ['id' => 'gender_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Subscribes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribes()
    {
        return $this->hasMany(Subscribe::class, ['user_id' => 'id']);
    }
}

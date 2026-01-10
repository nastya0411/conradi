<?php

namespace app\models;

use Yii;
use yii\rbac\Role;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $login
 * @property string $password
 * @property string $phone
 * @property string $birthday
 * @property int $role_id
 * @property string $auth_key
 *
 * @property Cart[] $carts
 * @property EstimationUser[] $estimationUsers
 * @property Order[] $orders
 * @property Role $role
 * @property Subscribe[] $subscribes
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'login', 'password', 'phone', 'birthday', 'auth_key'], 'required'],
            [['birthday'], 'safe'],
            [['role_id'], 'integer'],
            [['full_name', 'login', 'auth_key'], 'string', 'max' => 255],
            [['password', 'phone'], 'string', 'max' => 100],
            [['login'], 'unique'],
            [['phone'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'login' => 'Login',
            'password' => 'Password',
            'phone' => 'Phone',
            'birthday' => 'Birthday',
            'role_id' => 'Role ID',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[EstimationUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstimationUsers()
    {
        return $this->hasMany(EstimationUser::class, ['user_id' => 'id']);
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
        return $this->hasOne(Role::class, ['id' => 'role_id']);
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

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class User extends ActiveRecord implements IdentityInterface
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

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }



        public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername(string $login): null|object
    {
        return self::findOne(['login' => $login]);
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getIsAdmin(): bool
    {
        return $this->role_id == Role::getRoleId('admin');
    }

}

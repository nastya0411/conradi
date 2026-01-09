<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "baskets".
 *
 * @property int $id
 * @property float $total
 * @property int $amount
 * @property string $created_at
 * @property int $user_id
 * @property int $pay_type_id
 *
 * @property BasketItem[] $basketItems
 * @property TypesPay $payType
 * @property Users $user
 * @property Users $user0
 */
class Baskets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'baskets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'amount', 'created_at', 'user_id', 'pay_type_id'], 'required'],
            [['total'], 'number'],
            [['amount', 'user_id', 'pay_type_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypesPay::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total' => 'Total',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
            'pay_type_id' => 'Pay Type ID',
        ];
    }

    /**
     * Gets query for [[BasketItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBasketItems()
    {
        return $this->hasMany(BasketItem::class, ['basket_id' => 'id']);
    }

    /**
     * Gets query for [[PayType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(TypesPay::class, ['id' => 'pay_type_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}

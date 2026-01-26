<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property int $pay_type_id
 * @property string $address
 * @property int $status_id
 * @property string $date_time
 * @property string $created_at
 * @property int $pay_receipt
 * @property float $total
 *
 * @property OrderItem[] $orderItems
 * @property PayType $payType
 * @property Status $status
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    public $date;
    public $time;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {

        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total'], 'default', 'value' => 0.00],
            [['user_id', 'amount', 'pay_type_id', 'address', 'status_id', 'date_time', 'date', 'time'], 'required'],
            [['user_id', 'amount', 'pay_type_id', 'status_id', 'pay_receipt'], 'integer'],
            [['date_time', 'date', 'time', 'created_at'], 'safe'],
            [['total'], 'number'],
            [['address'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Заказ №',
            'user_id' => 'Клиент',
            'amount' => 'Количество товаров в заказе',
            'pay_type_id' => 'Способ оплаты',
            'address' => 'Адрес доставки заказа',
            'status_id' => 'Статус заказа',
            'date_time' => 'Дата и время получания заказа',
            'created_at' => 'Дата и время создания заказа',
            'pay_receipt' => 'Pay Receipt',
            'total' => 'Полная цена заказа',
            'date' => 'Дата получания заказ',
            'time' => 'Время получания заказ',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[PayType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::class, ['id' => 'pay_type_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    // public function afterSave($insert, $changedAttributes)
    // {
    //     parent::afterSave($insert, $changedAttributes);
    //     if (Yii::$app->id !== 'basic-console') {
    //         $this->sendMail();
    //         if (str_contains(Status::getStatuses()[$this->status_id], "Оплачен")) {
    //             $this->sendOfd(Yii::$app->params["userEmail"]);
    //         }
    //     }
    // }
}

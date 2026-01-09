<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "types_pay".
 *
 * @property int $id
 * @property string $pay_title
 *
 * @property Baskets[] $baskets
 * @property Order[] $orders
 */
class TypesPay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'types_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pay_title'], 'required'],
            [['pay_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_title' => 'Pay Title',
        ];
    }

    /**
     * Gets query for [[Baskets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBaskets()
    {
        return $this->hasMany(Baskets::class, ['pay_type_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['type_pay_id' => 'id']);
    }
}

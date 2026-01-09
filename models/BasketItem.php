<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "basket_item".
 *
 * @property int $id
 * @property int $basket_id
 * @property int $product_id
 * @property float $total
 * @property int $amount
 * @property float $price
 *
 * @property Baskets $basket
 * @property Products $product
 */
class BasketItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'basket_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['basket_id', 'product_id', 'total', 'amount', 'price'], 'required'],
            [['basket_id', 'product_id', 'amount'], 'integer'],
            [['total', 'price'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
            [['basket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Baskets::class, 'targetAttribute' => ['basket_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'basket_id' => 'Basket ID',
            'product_id' => 'Product ID',
            'total' => 'Total',
            'amount' => 'Amount',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Basket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBasket()
    {
        return $this->hasOne(Baskets::class, ['id' => 'basket_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $category_id
 * @property string $product_name
 * @property string $product_desciption
 * @property int $stock_quantity
 * @property int $type_product_id
 *
 * @property BasketItem[] $basketItems
 * @property Categories $category
 * @property Images $id0
 * @property OrderItem[] $orderItems
 * @property TypeProduct $typeProduct
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'product_name', 'product_desciption', 'stock_quantity', 'type_product_id'], 'required'],
            [['id', 'category_id', 'stock_quantity', 'type_product_id'], 'integer'],
            [['product_desciption'], 'string'],
            [['product_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Images::class, 'targetAttribute' => ['id' => 'product_id']],
            [['type_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeProduct::class, 'targetAttribute' => ['type_product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'product_name' => 'Product Name',
            'product_desciption' => 'Product Desciption',
            'stock_quantity' => 'Stock Quantity',
            'type_product_id' => 'Type Product ID',
        ];
    }

    /**
     * Gets query for [[BasketItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBasketItems()
    {
        return $this->hasMany(BasketItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Images::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[TypeProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypeProduct()
    {
        return $this->hasOne(TypeProduct::class, ['id' => 'type_product_id']);
    }
}

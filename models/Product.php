<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property float $stars
 * @property float $price
 * @property string $desciption
 * @property int $count
 * @property int $product_type_id
 *
 * @property CartItem[] $cartItems
 * @property Category $category
 * @property EstimationUser[] $estimationUsers
 * @property Image $id0
 * * @property Image $image 
 * @property OrderItem[] $orderItems
 * @property ProductType $productType
 */
class Product extends \yii\db\ActiveRecord
{

    public $imageFile;
    public $imageProduct;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stars'], 'default', 'value' => 0.0],
            [['price'], 'default', 'value' => 0],
            [['category_id', 'title', 'desciption', 'count', 'product_type_id'], 'required'],
            [['category_id', 'count', 'product_type_id'], 'integer'],
            [['stars', 'price'], 'number'],
            [['desciption'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::class, 'targetAttribute' => ['product_type_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Название продукта',
            'stars' => 'Stars',
            'price' => 'Цена',
            'desciption' => 'Описание',
            'count' => 'Количество на складе',
            'product_type_id' => 'Тип продукта',
            'imageFile' => 'Изображение продукта',

        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[EstimationUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstimationUsers()
    {
        return $this->hasMany(EstimationUser::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Image::class, ['product_id' => 'id']);
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
     * Gets query for [[ProductType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::class, ['id' => 'product_type_id']);
    }
    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {

                $this->imageProduct = time() . '_' . Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs('img/' . $this->imageProduct);
            }
            return true;
        } else {
            return false;
        }
    }
}

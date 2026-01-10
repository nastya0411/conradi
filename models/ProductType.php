<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_type".
 *
 * @property int $id
 * @property string $title
 *
 * @property Product[] $products
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title'], 'required'],
            [['id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['product_type_id' => 'id']);
    }
}

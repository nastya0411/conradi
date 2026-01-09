<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_product".
 *
 * @property int $id
 * @property string $type_title
 *
 * @property Products[] $products
 */
class TypeProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_title'], 'required'],
            [['id'], 'integer'],
            [['type_title'], 'string', 'max' => 255],
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
            'type_title' => 'Type Title',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['type_product_id' => 'id']);
    }
}

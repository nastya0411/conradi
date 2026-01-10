<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estimation_user".
 *
 * @property int $id
 * @property float $estimation
 * @property int $user_id
 * @property int $product_id
 *
 * @property Product $product
 * @property User $user
 */
class EstimationUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estimation_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id'], 'required'],
            [['id', 'user_id', 'product_id'], 'integer'],
            [['estimation'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estimation' => 'Estimation',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
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
}

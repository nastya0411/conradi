<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rewiews".
 *
 * @property int $id
 * @property string $description
 * @property int $user_id
 * @property string $date_time
 */
class Rewiews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rewiews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'description', 'user_id', 'date_time'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['date_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'user_id' => 'User ID',
            'date_time' => 'Date Time',
        ];
    }
}

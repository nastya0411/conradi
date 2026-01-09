<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "genders".
 *
 * @property int $id
 * @property string $gender_title
 *
 * @property Users[] $users
 */
class Genders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender_title'], 'required'],
            [['gender_title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gender_title' => 'Gender Title',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['gender_id' => 'id']);
    }
}

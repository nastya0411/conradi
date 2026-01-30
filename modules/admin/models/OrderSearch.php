<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{

    public $user_id;
    public $status_id;
    public $address;
    public $pay_type_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'amount', 'pay_type_id', 'status_id', 'pay_receipt'], 'integer'],
            [['address', 'date_time', 'created_at'], 'safe'],
            [['total'], 'number'],
        ];
    }

      public function search($params)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pay_type_id' => $this->pay_type_id,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address]);
        return $dataProvider;
    }
}

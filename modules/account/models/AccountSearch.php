<?php

namespace app\modules\account\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * AccountSearch represents the model behind the search form of `app\models\Order`.
 */
class AccountSearch extends Order
{
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

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'pay_type_id' => $this->pay_type_id,
            'status_id' => $this->status_id,
            'date_time' => $this->date_time,
            'created_at' => $this->created_at,
            'pay_receipt' => $this->pay_receipt,
            'total' => $this->total,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}

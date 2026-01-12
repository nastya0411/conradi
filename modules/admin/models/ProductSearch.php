<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * Product represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'count', 'product_type_id'], 'integer'],
            [['title', 'desciption'], 'safe'],
            [['stars', 'price'], 'number'],
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
        $query = Product::find();

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
            'category_id' => $this->category_id,
            'stars' => $this->stars,
            'price' => $this->price,
            'count' => $this->count,
            'product_type_id' => $this->product_type_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desciption', $this->desciption]);

        return $dataProvider;
    }
}

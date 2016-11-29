<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Feeds;

/**
 * FeedsSearch represents the model behind the search form about `app\models\Feeds`.
 */
class FeedsSearch extends Feeds
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'source_id'], 'integer'],
            [['type', 'uid', 'title', 'link', 'summary', 'author', 'date', 'img_link', 'img_name', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Feeds::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'source_id' => $this->source_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'uid', $this->uid])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'img_link', $this->img_link])
            ->andFilterWhere(['like', 'img_name', $this->img_name])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}

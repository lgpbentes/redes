<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Historia;

/**
 * HistoriaSearch represents the model behind the search form about `frontend\models\Historia`.
 */
class HistoriaSearch extends Historia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'autor', 'nome', 'imagem', 'descricao', 'moderador'], 'safe'],
            [['qteGostei', 'qteNaoGostei', 'qteDenuncias', 'duracao', 'status'], 'integer'],
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
        $query = Historia::find();

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
            'qteGostei' => $this->qteGostei,
            'qteNaoGostei' => $this->qteNaoGostei,
            'qteDenuncias' => $this->qteDenuncias,
            'duracao' => $this->duracao,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'autor', $this->autor])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'imagem', $this->imagem])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'moderador', $this->moderador]);

        return $dataProvider;
    }
}

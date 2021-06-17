<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\InfForTeacher;

/**
 * InfForTeacherSearch represents the model behind the search form of `backend\models\InfForTeacher`.
 */
class InfForTeacherSearch extends InfForTeacher
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'group_id', 'subject_id', 'type_id', 'status'], 'safe'],
            [['semester'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = InfForTeacher::find();

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
            'user_id' => $this->user_id,
//            'group_id' => $this->group_id,
            'subject_id' => $this->subject_id,
            'type_id' => $this->type_id,
            'status' => $this->status,
        ]);

        $query->joinWith(['group' => function ($q) {
            $q->where('`groups`.name LIKE "%' . $this->group_id . '%"');
        }]);

//        $query->joinWith(['user' => function ($q) {
//            $q->where('`username`.patronymic LIKE "%' . $this->user_id . '%"');
//        }]);

        $query->andFilterWhere(['like', 'semester', $this->semester]);

        return $dataProvider;
    }
}

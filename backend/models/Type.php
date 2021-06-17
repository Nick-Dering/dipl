<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "type".
 *
 * @property int $id
 * @property string $name
 * @property int|null $variant
 *
 * @property InfForTeacher[] $infForTeachers
 * @property Rating[] $ratings
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['variant'], 'integer'],
            [['name'], 'string', 'max' => 65],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип дисциплины',
            'variant' => 'Мера оценки (0 - зачет/незачет; 1 - пятибальная шкала)',
        ];
    }

    /**
     * Gets query for [[InfForTeachers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInfForTeachers()
    {
        return $this->hasMany(InfForTeacher::className(), ['type_id' => 'id']);
    }

    /**
     * Gets query for [[Ratings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['type_id' => 'id']);
    }

    public function getVariant()
    {
        $variant = $this->variant;
        switch ($variant){
            case 0:
                $arr[0] = 'Неявка';
                $arr[7]  = 'Зачет';
                $arr[8]  = 'Незачет';
                break;
            case 1:
                $arr[0] = 'Неявка';
                $arr[5]  = 'Отлично';
                $arr[4]  = 'Хорошо';
                $arr[3]  = 'Удовлетворительно';
                $arr[2]  = 'Неудов.';
                break;
        }
        return $arr;
    }
}

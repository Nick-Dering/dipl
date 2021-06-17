<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "specialties".
 *
 * @property int $id
 * @property string $name
 *
 * @property UserName[] $userNames
 */
class Specialties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specialties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Специальность',
        ];
    }

    /**
     * Gets query for [[UserNames]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNames()
    {
        return $this->hasMany(UserName::className(), ['specialty_id' => 'id']);
    }
}

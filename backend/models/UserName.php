<?php

namespace backend\models;

use common\models\User;
use Yii;


/**
 * This is the model class for table "user_name".
 *
 * @property int $id
 * @property int $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string|null $patronymic
 * @property int $status
 * @property int|null $group_id
 * @property int|null $specialty_id
 *
 * @property Rating[] $ratings
 * @property Rating[] $ratings0
 * @property Groups $group
 * @property Specialties $specialty
 * @property User $user
 */
class UserName extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_name';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'group_id', 'specialty_id'], 'integer'],
            [['firstname', 'patronymic'], 'string', 'max' => 35],
            [['lastname'], 'string', 'max' => 64],
            [['user_id'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['specialty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specialties::className(), 'targetAttribute' => ['specialty_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'status' => 'Статус (0 -студент/1 - преподаватель)',
            'group_id' => 'Группа',
            'specialty_id' => 'Специальность',
        ];
    }

    /**
     * Gets query for [[Ratings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Ratings0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatings0()
    {
        return $this->hasMany(Rating::className(), ['teacher_id' => 'id']);
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }

    /**
     * Gets query for [[Specialty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialty()
    {
        return $this->hasOne(Specialties::className(), ['id' => 'specialty_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFio()
    {
        return $this->lastname.' '.$this->firstname.' '.$this->patronymic;
    }
}

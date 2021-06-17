<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property int $id
 * @property int|null $teacher_id
 * @property int $subject_id
 * @property int|null $rating
 * @property string $date
 * @property int|null $type_id
 * @property int $student_id
 * @property int $semester
 *
 * @property UserName $student
 * @property Subject $subject
 * @property UserName $teacher
 * @property Type $type
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'subject_id', 'rating', 'type_id', 'student_id', 'semester'], 'integer'],
            [['subject_id', 'date', 'student_id', 'semester'], 'required'],
            [['date'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserName::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserName::className(), 'targetAttribute' => ['teacher_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_id' => 'Преподаватель',
            'subject_id' => 'Дисциплина',
            'rating' => 'Оценка',
            'date' => 'Дата',
            'type_id' => 'Тип дисциплины',
            'student_id' => 'Студент',
            'semester' => 'Семестр',
        ];
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(UserName::className(), ['id' => 'student_id']);
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * Gets query for [[Teacher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(UserName::className(), ['id' => 'teacher_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }
    
    public function getTypeRating($number){
        $rating = 'Нет данных';

        if ($number === null) return $rating;

        switch ($number){
            case 0:
                $rating =  'Неявка';
                break;
            case 2:
                $rating =  '2';
                break;
            case 3:
                $rating =  '3';
                break;
            case 4:
                $rating =  '4';
                break;
            case 5:
                $rating =  '5';
                break;
            case 7:
                $rating =  'Зачет';
                break;
            case 8:
                $rating =  'Незачет';
                break;
        }
        return $rating;
    }
}

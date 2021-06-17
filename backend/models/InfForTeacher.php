<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "inf_for_teacher".
 *
 * @property int $id
 * @property int $user_id
 * @property int $group_id
 * @property int $subject_id
 * @property int $type_id
 * @property string $semester
 * @property int $status
 *
 * @property Subject $subject
 * @property Groups $group
 * @property Type $type
 * @property UserName $user
 */
class InfForTeacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inf_for_teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id', 'subject_id', 'type_id', 'semester'], 'required'],
            [['user_id', 'group_id', 'subject_id', 'type_id', 'status'], 'integer'],
            [['semester'], 'string', 'max' => 2],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserName::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Преподаватель',
            'group_id' => 'Группа',
            'subject_id' => 'Дисциплина',
            'type_id' => 'Тип дисциплины',
            'semester' => 'Семестр',
            'status' => 'Статус',
        ];
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
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserName::className(), ['id' => 'user_id']);
    }
}

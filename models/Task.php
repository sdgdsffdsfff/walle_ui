<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $job_id
 * @property string $name
 * @property integer $status
 * @property string $start_time
 * @property string $finish_time
 *
 * @property Job $job
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_id', 'name'], 'required'],
            [['job_id', 'status'], 'integer'],
            [['start_time', 'finish_time'], 'safe'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'job_id' => 'Job ID',
            'name' => 'Name',
            'status' => 'Status',
            'start_time' => 'Start Time',
            'finish_time' => 'Finish Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }
}

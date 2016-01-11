<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property integer $version_id
 * @property integer $deployment_id
 * @property integer $worker_id
 * @property string $target_tasks
 * @property string $job_config
 * @property string $create_time
 * @property string $create_user
 * @property string $finish_time
 * @property integer $status
 * @property string $log_url
 *
 * @property ClientUpdatePackage[] $clientUpdatePackages
 * @property Version $version
 * @property Deployment $deployment
 * @property Worker $worker
 * @property Task[] $tasks
 */
class Job extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version_id', 'deployment_id', 'worker_id', 'status'], 'integer'],
            [['job_config'], 'string'],
            [['create_time', 'finish_time'], 'safe'],
            [['target_tasks'], 'string', 'max' => 512],
            [['create_user'], 'string', 'max' => 32],
            [['log_url'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version_id' => 'Version ID',
            'deployment_id' => 'Deployment ID',
            'worker_id' => 'Worker ID',
            'target_tasks' => 'Target Tasks',
            'job_config' => 'Job Config',
            'create_time' => 'Create Time',
            'create_user' => 'Create User',
            'finish_time' => 'Finish Time',
            'status' => 'Status',
            'log_url' => 'Log Url',
        ];
    }

    /**
     * expand parameter of toArray()
     */
    public function extraFields()
    {
        return array(
            'deployment_name' => function() {
                if (isset($this->deployment)) {
                    return $this->deployment->name;
                }
            }
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientUpdatePackages()
    {
        return $this->hasMany(ClientUpdatePackage::className(), ['job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersion()
    {
        return $this->hasOne(Version::className(), ['id' => 'version_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeployment()
    {
        return $this->hasOne(Deployment::className(), ['id' => 'deployment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorker()
    {
        return $this->hasOne(Worker::className(), ['id' => 'worker_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['job_id' => 'id']);
    }

}

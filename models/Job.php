<?php
namespace app\models;
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
    
    /**
     * 添加新数据
     * @param array $datas 新增的版本数据
     * @return bool
     */
    public static function createJob($datas)
    {
        $job = new Job();
        $job->version_id     = $datas['version_id'];
        $job->deployment_id  = $datas['deployment_id'];
        $job->worker_id      = $datas['worker_id'];
        $job->target_tasks   = $datas['target_tasks'];
        $job->create_time    = $datas['create_time'];
        $job->create_user    = $datas['create_user'];
        $job->status         = $datas['status'];
        $job->log_url        = $datas['log_url'];
    
        $bool = $job->insert();
        if($bool)
        {
            return $job->getOldAttribute('id');
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 更新job_config
     * @param int $jobId job id
     * @param string $jobConfig 
     * @return boolean
     */
    public static function modifyJobConfig($jobId, $jobConfig)
    {
        $job = Job::findOne($jobId);
        $job->job_config = $jobConfig;
        $bool = $job->save();
    
        return $bool;
    }
    
    /**
     * 根据打包机id,判断该打包机是否空闲
     * @param int $worker_id 打包机id
     * @return boolean
     */
    public static function getJobStatusByWorkerId($worker_id)
    {
        $condition = "worker_id={$worker_id} and (status=0 or status=1)";

        $result = Job::find()
                ->where($condition)
                ->orWhere(['status' => 0, 'status' => 1])
                ->asArray()
                ->all();
        
        if($result)
        {
            return true;  //非空闲状态
        }
        else
        {
            return false;  //空闲状态
        }
    }
}

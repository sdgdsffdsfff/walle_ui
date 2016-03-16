<?php
namespace app\models;
/**
 * This is the model class for table "worker".
 *
 * @property integer $id
 * @property string $hostname
 * @property integer $disable
 *
 * @property Job[] $jobs
 */

class Worker extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'disable'], 'integer'],
            [['hostname'], 'string', 'max' => 64],
            [['hostname'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hostname' => 'Hostname',
            'disable' => 'Disable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['worker_id' => 'id']);
    }
    
    /**
     * 获得空闲打包机
     * @param int $platformId 平台id
     * @return array
     */
    public static function getFreeData()
    {
        $condition = ['disable'=> 0];
        $result = Worker::find()
                ->where($condition)
                ->asArray()
                ->all();
        return $result;
    }
    
    /**
     *  根据id获取数据
     * @param int id 平台id
     * @return array
     */
    public static function getById($id)
    {
        $fields = ['id','hostname','disable'];
    
        $condition = ['id' => $id];
        $result = Worker::find()->select($fields)
                ->where($condition)
                ->asArray()
                ->one();
        
        return $result;
    }
    
    /**
     * 获取全部数据
     * @return array
     */
    public static function getAllData()
    {
        $result = Worker::find()->orderBy(['id' => SORT_DESC])->asArray()
                  ->all();
        
        return $result;
    }
    
    /**
     * 根据主机名获取记录
     * @param string $hostname 主机名
     * @return mixed
     */
    public static function getDataByHostname($hostname)
    {
        $condition = ['hostname' => $hostname];
        $result = Worker::findOne($condition);
        
        if(!empty($result))
        {
            return $result->toArray();
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 添加新的记录
     * @param array $datas 新数据
     * @return bool
     */
    public static function createWorker($datas)
    {
        $worker = new Worker();
        $worker->hostname = $datas['hostname'];
        $worker->disable = $datas['disable'];

        $bool = $worker->save();
        
        return $bool;
    }
    
    /**
     * 编辑记录
     * @param array $datas 所需数据
     * @return bool
     */
    public static function eidtWorker($datas)
    {
        $worker = Worker::findOne($datas['id']);
        $worker->hostname = $datas['hostname'];
        $worker->disable = $datas['disable'];
        
        $bool = $worker->save();
        
        return $bool;
    }
}

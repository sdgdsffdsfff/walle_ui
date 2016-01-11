<?php

namespace app\models;

use Yii;

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
            [['id'], 'required'],
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
        $condition = ['disable'=> 0 ];
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
}

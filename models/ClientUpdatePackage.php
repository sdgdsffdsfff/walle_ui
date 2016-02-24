<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_update_package".
 *
 * @property integer $from_version
 * @property integer $to_version
 * @property string $packages
 * @property integer $job_id
 *
 * @property Version $fromVersion
 * @property Version $toVersion
 * @property Job $job
 */
class ClientUpdatePackage extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_update_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_version', 'to_version'], 'required'],
            [['from_version', 'to_version', 'job_id'], 'integer'],
            [['packages'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'from_version' => 'From Version',
            'to_version' => 'To Version',
            'packages' => 'Packages',
            'job_id' => 'Job ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromVersion()
    {
        return $this->hasOne(Version::className(), ['id' => 'from_version']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToVersion()
    {
        return $this->hasOne(Version::className(), ['id' => 'to_version']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }
}

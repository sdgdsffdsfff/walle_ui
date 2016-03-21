<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "package_config".
 *
 * @property integer $package_id
 * @property integer $parameter_id
 * @property string $value
 *
 * @property Package $package
 * @property Parameter $parameter
 */
class PackageConfig extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'parameter_id'], 'required'],
            [['package_id', 'parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'package_id' => 'Package ID',
            'parameter_id' => 'Parameter ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'parameter_id']);
    }
    
    /**
     * 根据版本号获取数据
     * @param int $versionId 版本号
     * @return array
     */
    public static function getPackageConfigParams($packageList)
    {
        $condition = ['in' , 'package_id', $packageList];
    
        $resource = PackageConfig::find()->where($condition);
        $result = $resource->select('*')
        ->with([
                'parameter' => function($resource)
                {
                    $resource->select('*');
                }
        ])
        ->with([
                'package' => function($resource)
                {
                    $resource->select('*');
                }
        ])->asArray()->all();
    
        return $result;
    }
}

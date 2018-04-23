<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_cmp_server".
 *
 * @property int $company_id
 * @property int $server_id 服务ID
 * @property int $server_least 最低服务量
 * @property int $server_price 服务价格
 * @property int $server_parent_id 上级服务ID
 * @property int $server_type 类型：0非附加服务，1默认附加服务，2商家附加服务
 *
 * @property YxCompany $company
 * @property YxServer $server
 */
class YxCmpServer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yx_cmp_server';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['server_id'], 'required'],
            [['company_id', 'server_id', 'server_least', 'server_price', 'server_parent_id', 'server_type'], 'integer'],
            [['company_id', 'server_id'], 'unique', 'targetAttribute' => ['company_id', 'server_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxCompany::className(), 'targetAttribute' => ['company_id' => 'id']],
           [['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxServer::className(), 'targetAttribute' => ['server_id' => 'server_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'server_id' => '服务',
            'server_least' => '最低服务量',
            'server_price' => '服务价格',
            'server_parent_id' => '上级服务',
            'server_type' => '类型：0非附加服务，1默认附加服务，2商家附加服务',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
   public function getCompany()
   {
       return $this->hasOne(YxCompany::className(), ['id' => 'company_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getServer()
   {
       return $this->hasOne(YxServer::className(), ['server_id' => 'server_id']);
   }
    /**
     * {@inheritdoc}
     * @return YxCmpServerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxCmpServerQuery(get_called_class());
    }

    // 得到商家对应的的服务价格（oyzx）
    public static function getCompanyPrice($company_id,$server_id) {
      $YxCmpServer = YxCmpServer::find()->where(['company_id' => $company_id,'server_id' => $server_id])->one();
      return $YxCmpServer['server_price'];
    }

    // 得到商家的附加服务（oyzx）
    public static function getAddServerCompany($companyId,$serverId) {
      $addContent = "";
      $YxServer = YxCmpServer::find()->select(['*'])
                ->innerjoin('yx_company', 'yx_cmp_server.company_id=yx_company.id')
                  ->where(['yx_company.status'=>2])
                  ->andWhere(['yx_company.id' => $companyId])
                  ->andWhere(['yx_cmp_server.server_parent_id' => $serverId])
                  ->andWhere(['<>','yx_cmp_server.server_type',0])->all();
      if($YxServer) {
        $addContent = '<div class="long-hourly" style="margin: 5px;">
                				<div>您可以勾选以下附加服务：</div><div class="choose-server row">';
        foreach ($YxServer as $key => $value) {
          $YxCmpServer = number_format(YxServer::getServerThirdCompany($companyId,$value['server_id'])/100,2);
          $addContent = $addContent.'<div class="one-server col-md-3 col-lg-3"><input type="checkbox" name="server"/> '
            .YxServer::getServerName($value['server_id']). '<span  class="addserver"> '
            .$YxCmpServer.'</span>元/小时 <span class="server_num"> <input type="number" style="width:50px;" serverId="'.$value['server_id'].'" step="1" min="1" max="10" />小时</span></div>';
        }
        $addContent = $addContent.'</div></div>';
      }
      return $addContent;
    }
}

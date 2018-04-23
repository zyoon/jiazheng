<?php

namespace common\models;

use Yii;
use common\models\YxServer;

/**
 * This is the model class for table "yx_staff_server".
 *
 * @property int $staff_id 员工ID
 * @property int $server_id 服务ID
 * @property int $server_least 最低服务量
 * @property int $server_price 服务价格
* @property int $server_parent_id 一级服务ID
*
 * @property YxStaff $staff
 * @property YxServer $server
 */
class YxStaffServer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_staff_server';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server_id'], 'required'],
            [['staff_id', 'server_id', 'server_least', 'server_parent_id','server_type'], 'integer'],
            [['server_price'],'safe'],
            [['staff_id', 'server_id'], 'unique', 'targetAttribute' => ['staff_id', 'server_id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxStaff::className(), 'targetAttribute' => ['staff_id' => 'staff_id']],
            [['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxServer::className(), 'targetAttribute' => ['server_id' => 'server_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => '员工ID',
            'server_id' => '服务',
            'server_least' => '最低服务量',
            'server_price' => '单位服务价格',
            'server_parent_id' => '父级服务',
            'server_type'=>'服务类型',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(YxStaff::className(), ['staff_id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(YxServer::className(), ['server_id' => 'server_id']);
    }

    public static function getParentServerName($models)
    {
        $types = self::getParentServer();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }

    public static function getParentServer($staff_id){
        $info_staff=YxStaff::find()->where(['staff_id'=>$staff_id])->one();
        $str_server_id=$info_staff['staff_main_server_id'].','.$info_staff['staff_all_server_id'];
        $str_server_name=YxStaff::getAllServer($str_server_id);
        $arr_server_id=explode(',', $str_server_id);
        $arr_server_name=explode(',',$str_server_name);
        $arr_server=[];
        foreach ($arr_server_id as $key => $value) {
            $arr_server[$value]=$arr_server_name[$key];
        }
        return $arr_server;
    }


    public static function getChildServer($server_parent_id){
        $arr_child_server=YxServer::find()->where(['server_parent'=>$server_parent_id])->all();
        $map_child_server=[];
        foreach ($arr_child_server as $key => $value) {
            $map_child_server[$value['server_id']]=$value['server_name'];
        }
        return $map_child_server;
    }
    /**
     * @inheritdoc
     * @return YxStaffServerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxStaffServerQuery(get_called_class());
    }

    // 得到服务人员所有服务（oyzx）
    public static function getServerAll($staff_id) {
      $YxStaffServer = YxStaffServer::find()->where(['staff_id' => $staff_id,'server_type' => 0])->all();
      return $YxStaffServer;
    }
    // 得到服务的服务单位（oyzx）
    public static function getServerUnit($server_id) {
      $YxServer = YxServer::find()->where(['server_id' => $server_id])->one();
      return $YxServer['server_unit'];
    }
    // 得到服务人员对应的的服务价格（oyzx）
    public static function getStaffPrice($staff_id,$server_id) {
      $YxServer = YxStaffServer::find()->where(['staff_id' => $staff_id,'server_id' => $server_id])->one();
      return $YxServer['server_price'];
    }
    // 得到服务人员的附加服务（oyzx）
    public static function getAddServer($staffId,$serverId) {
      $addContent = "";
      $YxServer = YxStaffServer::find()->select(['*'])
                ->innerjoin('yx_staff', 'yx_staff_server.staff_id=yx_staff.staff_id')
                  ->where(['yx_staff.staff_state'=>1,'yx_staff_server.server_parent_id' => $serverId])
                  ->andWhere(['<>','yx_staff_server.server_type',0])->all();
      if($YxServer) {
        $addContent = '<div class="long-hourly" style="margin: 5px;">
                				<div>您可以勾选以下附加服务：</div><div class="choose-server">';
        foreach ($YxServer as $key => $value) {
          $YxStaffServer = YxServer::getServerThird($staffId,$value['server_id']);
          $addContent = $addContent.'<div class="one-server"><input type="checkbox" name="server"> '
          .YxServer::getServerName($value['server_id']).' <span class="addserver">'
          .$YxStaffServer.'</span>元/小时 <span class="server_num"><input text="number" style="width:50px;/>小时</span></div>';
        }
        $addContent = $addContent.'</div></div>';
      }
      return $addContent;
    }
}

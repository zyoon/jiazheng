<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord {
	
	public function attributeLabels() {
        return [
            'id' => '编号',
            'create_time' => '创建时间',
            'name'=>'用户名',
            'password'=>'Password',
            'sex'=>'性别',
            'province'=>'省',
            'city'=>'市',
            'img'=>'照片',       
        ];
    }
}
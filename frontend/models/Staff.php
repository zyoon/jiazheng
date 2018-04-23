<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use Yii;

class Staff extends ActiveRecord {
	public static function tableName() {
		return "yx_staff";
	}

	public function attributeLabels() {
        return [
            'staff_id',
            'store_id',
			'staff_name'=>'人名',      
        ];
    }
}
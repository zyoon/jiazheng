<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use Yii;

class Store extends ActiveRecord {
	public static function tableName() {
		return "yx_store";
	}

	public function attributeLabels() {
        return [
            'store_id',
			'store_name'=>'店名',
			'store_intro'=>'简介',
			'store_img'=>'图片'        
        ];
    }
}
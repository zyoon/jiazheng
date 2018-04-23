<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use Yii;

class Admin extends ActiveRecord {

	public static function tableName() {
		return "{{%admin}}";
	}
}

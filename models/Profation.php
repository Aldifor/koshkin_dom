<?php
namespace app\models;

use yii\db\ActiveRecord;

class Profation extends ActiveRecord{
    public static function tableName(){
        return 'profations';
    }
}
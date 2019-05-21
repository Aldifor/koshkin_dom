<?php
namespace app\models;

use yii\db\ActiveRecord;

class NavbarAdmin extends ActiveRecord{

    public static function tableName(){
        return 'navbar_admin';
    }
}
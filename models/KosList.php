<?php
namespace app\models;

use yii\db\ActiveRecord;

class KosList extends ActiveRecord{
    // public static function tableName(){
    //     return 'Kos_list';
    // }
    public function rules(){
        return[
            [['nicname','prof','text'],'required'],
            ['status','safe'],
            [['nicname','prof','text'],'trim'],
            ['nicname', 'string', 'length' => [1, 9], ],
        ];
    }
    public function attributeLabels(){
        return [
            'status'=> 'Статус',
            'nicname'=>'Ник',
            'prof'=>'Профа',
            'text'=>'Описание',
        ];
    }
}
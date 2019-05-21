<?php
namespace app\models;

use Yii;
use yii\base\Model;

class Date extends Model{
    public static function explodeDate($date_time, $chat = false){
        
        $date_time = explode(" ", $date_time);
        $date = explode("-", $date_time[0]);
        $time = explode(":", $date_time[1]);
        
        if($chat)
            $d_str = $date[2].".".$date[1];
        else
            $d_str = $date[2].".".$date[1].".".$date[0];

        $t_str = $time[0].":".$time[1];

        return compact('d_str','t_str');
    }
}
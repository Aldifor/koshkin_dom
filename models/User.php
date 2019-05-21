<?php
namespace app\models;

use Yii;
use app\models\News;
use yii\db\ActiveRecord;

class User extends ActiveRecord{
    public static function tableName(){
        return 'users';
    }
    public static function get_users($params){
        $base_sql = "SELECT id, name, nicname, profation as prof_id, is_party, admit, root, post as post_id FROM users us WHERE id != :id ";
        switch ($params['type']) {
            case 'all':
                $query_sel_us = $base_sql."ORDER BY id DESC";
                break;
            case 'new':
                    $query_sel_us = $base_sql."and new_user = 1 ORDER BY id DESC";
                break;
            case "admitn't":
                    $query_sel_us = $base_sql."and admit != 1 ORDER BY id DESC";
                break;
            case 'admit':
                    $query_sel_us = $base_sql."and admit != 0 ORDER BY id DESC";
                break;
            case 'party':
                    $query_sel_us = $base_sql."and is_party = 1 ORDER BY id DESC";
                break;
            case 'guest':
                    $query_sel_us = $base_sql."and is_party = 0 ORDER BY id DESC";
                break;
        }
        // echo $query_sel_us;
        return Yii::$app->db->createCommand($query_sel_us)->bindValue(":id", $params['id'])->queryAll();
    }
    public static function up_users($params){
        if($params[":root"]){
            $query = 'UPDATE users SET admit = :admit, is_party = :party, post = :post, root = :root WHERE id = :id';
                $param = [
                ':id' => $params[':id'],
                ':root' => $params[':root'],
                ':post' => $params[':post'],
                ':admit' =>$params[':admit'],
                ':party' => $params[':party'],
            ];
        }
        else{
            $query = "UPDATE users SET admit = :admit, is_party = :party, post = :post WHERE id = :id";
            $param = [
                ':id' => $params[':id'],
                ':root' => $params[':root'],
                ':post' => $params[':post'],
                ':admit' =>$params[':admit'],
                ':party' => $params[':party'],
            ];
        }
        
        if($params['type'] == 'new'){
            $query = "UPDATE users SET new_user = 0 WHERE id = :id";
            Yii::$app->db->createCommand($query)
                ->bindValue(':id',$params['id'])
                ->execute();
        }
        return Yii::$app->db->createCommand($query)->bindValues($param)->execute();
    
    }
}

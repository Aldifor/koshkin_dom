<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Date;

class Chat extends Model{

    public static function getMessage($params = []){
        extract($params);
        $order = ' ORDER BY mes.id ';
        if($dialog){
            $query = "SELECT mes.id as mes_id, mes.from_us, mes.to_us, mes.message, mes.date, us.nicname, 
                        ( SELECT prof_icon FROM profations WHERE id = us.profation ) as prof_icon, 
                        us.name, us.id as us_id,
                        ( SELECT item_post FROM post WHERE id = us.post ) as post
                                FROM messages AS mes INNER JOIN users AS us ON mes.from_us = us.id INNER JOIN 
                                ( SELECT from_us, MAX(id) max_id FROM messages WHERE to_us = :us_id GROUP BY from_us ) AS mes2 ON 
                                    mes.from_us = mes2.from_us AND mes.id = mes2.max_id ORDER BY mes.id DESC";
            $params = [
                ':us_id' => $_SESSION['id'],
            ];
        }
        elseif(!$message){

            $sql = Chat::getSql();
            if($type != 'private' && !$mes_id){      // выводит все сообщения общего/кланового чата
                $query = $sql . "mes.$type = 1 and us.id = mes.from_us and private != 1".$order." LIMIT 300";
            }
            elseif($type =='private' && !$mes_id){      // выводит все сообщения лс
                $query = $sql . "(from_us = :from_us and to_us = :to_us and from_us = us.id
                                    OR from_us = :to_us and to_us = :from_us and from_us = us.id) and $type = 1";
            }
            elseif( $type != 'private' && $mes_id){     // выводит новые сообщения в общем/клановом
                $query = $sql . "us.id = mes.from_us and mes.$type = 1
                                    and mes.id > :mes_id and mes.from_us != :from_us and to_us = :to_us";
            }
            elseif($type == 'private' and $mes_id){ // вывод новых сообщений в лс
                $query = $sql . "us.id = mes.from_us
                                    and mes.id > :mes_id and mes.to_us = :from_us and mes.from_us = :to_us";
            }
            if(!($type != 'private' && !$mes_id)) $query.=$order;
            $params  = [
                ':to_us' =>$to_us,
                ':from_us' =>$_SESSION['id'],
                ':mes_id' => $mes_id,
            ];
            // debug($params);
            // debug($query);

        }elseif($message){
            $datenow = date('Y-m-d H:i:s');

                $query = "INSERT INTO messages ($type, from_us, to_us, message, date) VALUES (1, :us_id, :to_us, :message, :datenow)";
                $params = [
                    ':us_id' => $_SESSION['id'],
                    ':to_us' => $to_us,
                    ':message' => $message,
                    ':datenow' => $datenow
                ];
            Yii::$app->db->createCommand($query)->bindValues($params)->execute();

            $last_id = Yii::$app->db->getLastInsertID();

            $query = Chat::getSql() . "mes.id = :last_id and us.id = mes.from_us ";
            $params = [
                ':last_id' => $last_id
            ];
        }
        $mes = Yii::$app->db->createCommand($query)->bindValues($params)->queryAll();
        return Chat::mesBlock( Chat::replaceSmile($mes) );
    }
    public static function getSmile($type_smile){
        $html =  '<div class="smile_content row">';
                    for($i = 1; $i < 51; $i++){
                        $html .= '<div class="m-1" name="smile"><img id="%' . $type_smile . '-' . $i . '%" class="smile mr-1" src="/img/smiles/' . $type_smile . '/' . $i . '.gif' . '"  > </div>';
                    }
        $html .= '</div>';
        return $html;
    }
    public static function inComment($params){
        extract($params);
            $datenow = date('Y-m-d H:i:s');
            $query = "INSERT INTO comment (new_id, us_id, message, date) VALUES (:new_id, :us_id, :message, :datenow)";
            $params = [
                ':us_id' => $_SESSION['id'],
                ':new_id' => $new_id,
                ':message' => $message,
                ':datenow' => $datenow
            ];
            Yii::$app->db->createCommand($query)->bindValues($params)->execute();

            $last_id = Yii::$app->db->getLastInsertID();

            // $query = Chat::getSql() . "mes.id = :last_id and us.id = mes.from_us ";
            $query = 'SELECT com.*, us.name, us.id as us_id, us.is_party, us.nicname,
                            (SELECT item_post FROM post WHERE id = us.post) as post,
                                (SELECT prof_name FROM profations WHERE id = us.profation) as prof,
                                    (SELECT prof_icon FROM profations WHERE id = us.profation) as prof_icon  FROM comment com, users us 
                                        WHERE com.id = :last_id and com.us_id = us.id';
            $params = [
                ':last_id' => $last_id
            ];
        $mes = Yii::$app->db->createCommand($query)->bindValues($params)->queryAll();
        return Chat::mesBlock( Chat::replaceSmile($mes) );
    }
    public static function replaceSmile($mes){
        $serch_id = "/\w+-\d\d?/";
        for($i = 0; $i<count($mes); $i++){
                preg_match_all($serch_id,$mes[$i]['message'],$smileid);
                // debug($smileid);
                    foreach($smileid as $item){
                        foreach($item as $id){
                            $smile_id = explode('-',$id);
                            $replaces = "<img class='smile mr-1'src='/img/smiles/$smile_id[0]/$smile_id[1].gif'alt=''>";
                            $mes[$i]['message'] = str_replace('%'.$id.'%', $replaces, $mes[$i]['message']);
                        }
                    }
            }
        return $mes;
    }
    public static function mesBlock($mes){
        $html = '';
        foreach($mes as $item){
            $item['date'] = Date :: explodeDate($item['date'],true);
            $html .= '<div class="mes-block mb-1 border-success" id="'
            . $item['us_id'] .
                        '">
                        <div class="row justify-content-between px-2 pt-2">
                            <div data-toggle="tooltip" class="nicname"
                                title="';
                                if($item['us_id']!= $_SESSION['id']){
                                        $html .="<img class='prof_icon' src='" . $item['prof_icon'] . "'>";
                                    $html .='<br>
                                        <span>' . $item['name'] . '</span>
                                    <br>';

                                        if($item['is_party']){

                                            $html .= '<span>' . $item['post'] . '</span>';

                                        }
                                        elseif(!($item['is_party'])){
                                            $html .= '<span>Гость</span>';

                                        }
                                }
                                    $html .='">';
                                    if($item['us_id']!= $_SESSION['id']){
                                        $html .= ' <a href="/communication/private?id='.$item['us_id'].'">'.$item['nicname'].'</a>';
                                    }else{
                                        $html .= $item['nicname'];
                                    }
                        $html.= '</div>
                        <div class="mes-date" data-toggle="tooltip" class=""
                            title="' . $item['date']['d_str'] . '">' .
                            $item['date']['t_str'] .
                        '</div>
                    </div>

                <div class="mes-body px-3 col-10 pb-2" id="' . $item['mes_id'] . '">' .
                    $item['message'] .
                '</div>
            </div>';
        }
        return $html;
    }
    private static function getSql(){
        return "SELECT mes.message, mes.id as mes_id, mes.date, us.name, us.id as us_id, us.is_party, us.nicname,
                    (SELECT item_post FROM post WHERE id = us.post) as post,
                    (SELECT prof_name FROM profations WHERE id = us.profation) as prof,
                    (SELECT prof_icon FROM profations WHERE id = us.profation) as prof_icon
                FROM messages mes, users us WHERE ";
    }
}

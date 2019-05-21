<?php
namespace app\models;

use yii\base\Model;


class PostVk extends Model{

    public $access_token;
    public $group_id;
    public $client_id;
    public $model;
    private $url = "https://api.vk.com/method/";

    public function __construct($params,$model = false){
        extract($params);
        $this->access_token = $token;
        $this->group_id = $group_id;
        $this->client_id = $client_id;
        $this->model = $model;
    }
    
    public function getToken($scope,$response_type){
        $display = 'page'; 
        // $redirect_uri = 'http://cathouse.loc/admin'; 
        $redirect_uri = 'https://oauth.vk.com/blank.html'; 
        $group_ids = $this->group_id; 
        $v = '5.95'; 
        $url = 'https://oauth.vk.com/authorize?'; 
            header('location:'.$url.http_build_query(compact('client_id','display','redirect_uri','scope','response_type')));
        }
            
    public function pubNew($from_group = 0){
        $message = $this->model->title.' 
                    '.$this->model->body;
        // if($this->model->img){
        //     $url = 'https://api.vk.com/method/photos.getWallUploadServer?';
        //     $params = [
        //         'group_id'=>$this->group_id,
        //         'access_token'=> $this->access_token,
        //         'v' => '5.95',
        //     ];
        //     $url = $this->curl($url,$params)->response->upload_url;
        //     // debug($this->curl($url,['photo'=> curl_file_create($this->model->postImg['tempName'],$this->model->postImg['type'],$this->model->img)]));
        //     debug($this->uploadImage($url,$_SERVER['DOCUMENT_ROOT'].'/upload/'.$this->model->img));
        //     die;
        // }
        // return;
        $url ='https://api.vk.com/method/wall.post?';
        $params = [
            'owner_id' => '-'.$this->group_id,
            'access_token' => $this->access_token,
            'from_group'=>$from_group,
            'message'=>strip_tags($message),
            'v'=>'5.95',
        ];
        return json_decode(file_get_contents($url.http_build_query($params)));
    }
    public function curl($url,$dataoptions){
            // debug([$url,$dataoptions]);
        $ch = curl_init($url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$dataoptions);
            $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
        // return $result;
    }

    public function method($method, $params = null) {

        $p = "";
        if( $params && is_array($params) ) {
            foreach($params as $key => $param) {
                $p .= ($p == "" ? "" : "&") . $key . "=" . urlencode($param);
            }
        }
        $response = file_get_contents($this->url . $method . "?" . ($p ? $p . "&" : "") . "access_token=" . $this->access_token);

        if( $response ) {
            return json_decode($response);
        }
        return false;
    }

    public function uploadImage($server,$file, $group_id = null, $album_id = null) {

        $params = array();
        if( $group_id ) {
            $params['group_id'] = $group_id;
        }
        if( $album_id ) {
            $params['album_id'] = $album_id;
        }

    // $postparam=array("photo"=>"@".$file);
    $postparam=array("photo"=>curl_file_create($this->model->img, $this->model->postImg['type'], $_SERVER['DOCUMENT_ROOT'].'/upload/'.$this->model->img));
    debug(realpath('upload/'.$this->model->img));
    //Отправляем файл на сервер
    $ch = curl_init($server);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$postparam);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; charset=UTF-8'));
    $json = json_decode(curl_exec($ch));
    curl_close($ch);
    // debug($json);

    //Сохраняем файл в альбом
    $photo = $this->method("photos.save", array(
      "server" => $json->server,
      "photos_list" => $json->photos_list,
    //   "album_id" => $album_id,
      "hash" => $json->hash,
      'gid' => $group_id
    ));
    

    if( isset($photo->response[0]->id) ) {
      return $photo->response[0]->id;
    } else {
      return false;
    }
  }
}

<?php
namespace app\components;

class Vk {

    public $access_token;
    public $group_id;
    public $client_id;
    public $model;
    private $url = "https://api.vk.com/method/";

    public function __construct($params, $model = false){
        extract($params);
        $this->access_token = $token;
        $this->group_id = $group_id;
        $this->client_id = $client_id;
        $this->model = $model;
    }
    
    public function getToken($scope, $response_type){
        $display = 'page'; ; 
        $url = 'https://oauth.vk.com/authorize?';
        $redirect_uri = 'https://oauth.vk.com/blank.html';
        $group_ids = $this->group_id;
        $v = '5.95';
            header('location:'.$url.http_build_query(compact('client_id','display','redirect_uri','scope','response_type')));
    }
            
    public function pubNew($from_group = 0){
        $message = $this->model->title.' 
                    '.$this->model->body;
        if($this->model->img){
            $url = $this->url.'photos.getWallUploadServer?';
            $params = [
				'group_id'=>$this->group_id,
                'access_token'=> $this->access_token,
                'v' => '5.95',
            ];
			
			$url = $this->curl($url,$params)->response->upload_url;
			$request = $this->curl($url, ['photo'=>curl_file_create($this->model->path , mime_content_type($this->model->path), basename($this->model->path))], true);
			
            $url = $this->url.'photos.saveWallPhoto?';
			$params =[
				'photo'        => $request->photo,
				'server'       => $request->server,
				'hash'         => $request->hash,
				'group_id'     => $this->group_id,
				'access_token' => $this->access_token,
				'v'            =>'5.95',
			];

			$img_response = $this->curl($url,$params)->response[0];
        }
		
        $url =$this->url.'wall.post?';
        $params = [
            'owner_id'     => '-'.$this->group_id,
            'access_token' => $this->access_token,
            'from_group'   =>$from_group,
			'message'      =>strip_tags($message),
			'attachments'  =>($img_response) ? 
                                            'photo'.$img_response->owner_id . '_' . $img_response->id.',http://'.$_SERVER['HTTP_HOST'].'/news?id=' . $this->model->id : 
                                            'http://'.$_SERVER['HTTP_HOST'].'/news?id=' . $this->model->id,
            'v'=>'5.95',
        ];
        return $this->curl($url,$params);
    }
    public function curl($url, $dataoptions, $multipart = false){
        $ch = curl_init($url);
			if($multipart){
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; charset=UTF-8'));
			}
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
            curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$dataoptions);
            $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

}
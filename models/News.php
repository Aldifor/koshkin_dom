<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\db\ActiveRecord;

class News extends ActiveRecord{
    public $postImg;

    public static function tableName(){
        return 'new';
    }
    public static function getNews($id = false, $del = false,$main = false){
        if(!$id){
            if($del)
                $sql = 'SELECT n.*, us.nicname, us.name, us.post FROM new n, users us WHERE us.id = n.creat_user_id and deleted != 0 ORDER BY n.id';
            else
                $sql = 'SELECT n.*, us.nicname, us.name, us.post FROM new n, users us WHERE us.id = n.creat_user_id and deleted != 1 ORDER BY n.id';
                if($main){
                    $sql.=' DESC LIMIT 5';
                }
            return [
                'news' =>Yii::$app->db->createCommand($sql)->queryAll(),
            ];
        }else{
            $sql = 'SELECT n.*, us.nicname, us.name, us.post FROM new n, users us WHERE us.id = n.creat_user_id and n.id = :id';
            $news = Yii::$app->db->createCommand($sql)->bindValue(':id',$id)->queryAll();
            $comments = Yii::$app->db->createCommand(
                        'SELECT com.*, us.name, us.id as us_id, us.is_party, us.nicname,
                            (SELECT item_post FROM post WHERE id = us.post) as post,
                                (SELECT prof_name FROM profations WHERE id = us.profation) as prof,
                                    (SELECT prof_icon FROM profations WHERE id = us.profation) as prof_icon  FROM comment com, users us
                                        WHERE new_id = :id and com.us_id = us.id
                                        ')
                        ->bindValue(':id',$id)
                        ->queryAll();
                        $comments = Chat::replaceSmile($comments);
            return compact('news','comments');
        }
    }

    public static function deleteNew($id, $del = false, $restore = false){
        if($del){
            $img = Yii::$app->db->createCommand('SELECT img FROM new WHERE id = :id ')
                        ->bindValue(':id',$id)
                        ->queryAll();
            Yii::$app->db->createCommand('DELETE FROM new WHERE id = :id')
                            ->bindValue(':id',$id)
                            ->execute();
            Yii::$app->db->createCommand('DELETE FROM comment WHERE new_id = :id')
                            ->bindValue(':id',$id)
                            ->execute();
            if(!empty($img)){
                if(file_exists('uploads/'.$img[0]['img'])){
                    unlink('uploads/'.$img[0]['img']);
                }
            }
        }elseif($restore){
            Yii::$app->db->createCommand('UPDATE new SET deleted = 0 WHERE id = :id')
                ->bindValue(':id', $id)
                ->execute();
        }
        else{
            Yii::$app->db->createCommand('UPDATE new SET deleted = 1 WHERE id = :id')
                ->bindValue(':id', $id)
                ->execute();
        }
    }

    public function attributeLabels(){
        return [
            'title'=>'Заголовок',
            'img'=>'Прикрепить Изображение',
            'body'=>'Текст',
            'postVk' => '',
        ];
    }
    public function rules(){
        return[
            [['body','title'],'required'],
            [['img'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['body','title'],'trim'],
            [['body','title'],'string'],
        ];
    }
    public function upload(){
        if ($this->validate()) {
            $this->postImg = [
                'tempName'=> $this->img->tempName,
                'type'=>$this->img->type,
                ];
            $fileName = $this->getFileName();
            $this->img->saveAs($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $fileName );
            $this->img = $fileName;
            return true;
        } else {
            return false;
        }
    }
    

    public function getUser(){
        return $this->hasOne(User:: className(),['id'=>'user']);
    }
    private function getFileName(){
        return strtolower(md5(uniqid($this->img->baseName))) . '.' . $this->img->extension;
    }
}
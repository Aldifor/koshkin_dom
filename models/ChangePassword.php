<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\News;


class ChangePassword extends Model{
    public $current_password;
    public $password;
    public $password_repet;
    private $id;
    public function __construct(){
        $this->id = $_SESSION['id'];
        // $this->current_password = Yii::$app->db->createCommand('SELECT password FROM users WHERE id = :id')->bindValue(':id',$this->id)->queryAll()[0]['password'];
    }
    public function rules(){
        return[
            [['current_password', 'password', 'password_repet'], 'required'],
            ['password', 'string', 'min' => 8],
            ['password_repet', 'compare', 'compareAttribute' => 'password'],
        ];
    }
    public function attributeLabels(){
        return[
            'current_password'=>'Существующий пороль',
            'password' => 'Новый пороль',
            'password_repet' => 'Повторите пороль',
        ];
    }
    public function changePassword(){
        if($this->validate()){
            $this->password = md5($this->password);
            $this->current_password = md5($this->current_password);
            if($this->current_password == Yii::$app->db->createCommand('SELECT password FROM users WHERE id = :id')->bindValue(':id',$this->id)->queryAll()[0]['password']){
                if(Yii::$app->db->createCommand('UPDATE users SET password = :password WHERE id = :id')->bindValues([':id'=>$this->id, ':password'=>$this->password])->execute()){
                    return true;
                }

            }
            else{
                return false;
            }
        }
    }

}
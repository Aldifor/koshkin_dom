<?php
namespace app\controllers;

use Yii;
use app\models\Navbar;
use yii\web\Controller;

class AppController extends Controller{
    public $navbar;
    public $navActiv;
    public $user_root;
    public $user_root_sql = 'SELECT root, is_party, admit, post FROM users WHERE id = :id';
    public  function  beforeAction($action){
        $this->user_root = Yii::$app->db->createCommand($this->user_root_sql)->bindValues([':id' => $_SESSION['id']])->queryAll()[0];
        $this->navActiv = $action->id;
        if($action->id =='communication-private'){
            $this->navActiv = 'communication';
        }

        return parent::beforeAction($action);
    }

    public function debug($arr){

        echo'<pre>'.vat_dump($arr,true).'</pre>';

    }
}

<?php

namespace app\controllers;
use Yii;
use app\models\Chat;
use app\models\Date;
use app\models\News;
use app\models\User;
use app\models\Navbar;
use app\models\KosList;
use app\models\Profation;


Class MainController extends AppController{
    public function beforeAction($action){

        $this->navbar = Navbar::find()->asArray()->all();

        return parent::beforeAction($action);
    }
    public function actionIndex(){
        if( Yii :: $app->request->isAjax){
            $this->avtoriz();
            $params = $this->getParams();
            //////////////////////////////////// del news ////////////////////////////////////////////

                if($params['type']){ //del
                    News :: deleteNew($params['new_id'], true);
                }else{//mDel
                    News :: deleteNew($params['new_id']);
                }

            exit;
        }
        $news = News :: getNews(0,0,1)['news'];
        foreach ($news as $k => $new){
            $news[$k]['date'] = Date :: explodeDate($news[$k]['date']);
        }
        return $this->render('index',compact('news'));
    }
    public function actionAbclan(){
        if( Yii :: $app->request->isAjax){
            $this->avtoriz();
            exit;
        }
        $kos = KosList :: find()->asArray()->all();
        $prof = Profation :: find()->asArray()->all();
        return $this->render('abclan',compact('kos','prof'));
    }
    public function actionNews($id = false){
        if( Yii :: $app->request->isAjax){
            $this->avtoriz();
            $params = $this->getParams();
            if($params['type_smile']) {
                return Chat::getSmile($params['type_smile']);
            }
            if($params['message']){
                return Chat::inComment($params);
            }

            //////////////////////////////////// del news ////////////////////////////////////////////
                // debug($params);
            if($params['type']){ //del
                News :: deleteNew($params['new_id'], true);
            }elseif($params['restore']){//restoreDel
                News :: deleteNew($params['new_id'], false, true);
            }
            else{//marcDel
                News :: deleteNew($params['new_id']);
            }

            exit;
        }

        if(isset($_GET['deleted']))
            $arr = News :: getNews($id,true);
        else
            $arr = News :: getNews($id);
        if($id)
            $news = $arr['news'][0]??false;
        else
            $news = $arr['news']??false;

        if($arr['comments'])
            $comments = Chat :: mesBlock(array_reverse($arr['comments']));

        if(!$id)
            foreach ($news as $k => $new){
                $news[$k]['date'] = Date :: explodeDate($news[$k]['date']);
            }
        else
            $news['date'] = Date :: explodeDate($news['date']);
        return $this->render('news',compact('news','comments','id'));
    }
    public function actionCommunication(){
        if( Yii :: $app->request->isAjax){
            $this->avtoriz();
            $params =$this-> getParams();
                if(!$params['type_smile']){
                    echo Chat::getMessage($params);
                }
                elseif($params['type_smile']) {
                    echo Chat::getSmile($params['type_smile']);
                }
            exit;
        }

        if(!isset($_SESSION['id'])){
            return $this->redirect(['/']);
        }
        return $this->render('communication');
    }
    public function actionCommunicationPrivate(){
        if( Yii :: $app->request->isAjax){
            $this->avtoriz();
            $params = $this-> getParams();
                if(!$params['type_smile']){
                    echo Chat::getMessage($params);
                }
                elseif($params['type_smile']) {
                    echo Chat::getSmile($params['type_smile']);
                }
            exit;
        }

        if(!isset($_SESSION['id'])){
            return $this->redirect(['/']);
        }
        $us = Yii::$app->db->createCommand('SELECT id, nicname, is_party as party,(SELECT item_post FROM post WHERE id = us.post) as post, name, 
                                                (SELECT prof_icon FROM profations WHERE id = us.profation) as prof_icon 
                                                        FROM users us')
                                                ->queryAll();
        return $this->render('private',compact('us'));
    }
    public function actionUseful(){
        if( Yii :: $app->request->isAjax){
            $this->avtoriz();
            exit;
        }
        return $this->render('useful');
    }
    public function actionVoiseservis(){
        if( Yii :: $app->request->isAjax){
            $this->avtoriz();
            exit;
        }
        return $this->render('voiseservis');
    }



//  functions
    public function getParams(){
        return [
            'type'  => filter_input(INPUT_POST,'type',FILTER_SANITIZE_STRING) ?? false,
            'to_us'  => filter_input(INPUT_POST,'to_us',FILTER_SANITIZE_STRING) ?? 0,
            'mes_id'  => filter_input(INPUT_POST,'mes_id',FILTER_SANITIZE_STRING) ?? false,
            'dialog' => filter_input(INPUT_POST,'dialog',FILTER_SANITIZE_STRING) ?? false,
            'type_smile' => filter_input(INPUT_POST,'type_smile',FILTER_SANITIZE_STRING) ?? false,
            'message' => filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING) ?? false,
            'new_id' => filter_input(INPUT_POST,'new_id',FILTER_SANITIZE_STRING) ?? false,
            'restore' => filter_input(INPUT_POST,'restore',FILTER_SANITIZE_STRING) ?? false,
        ];
    }
    public function avtoriz(){
        if(isset($_POST['session']) && $_POST['session'] == 'false'){
                $sql = "SELECT  password FROM users WHERE login = :login";

                $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_EMAIL)??false;

                $result = Yii::$app->db->createCommand($sql)->bindValues([':login' => $login])->queryAll();
                echo json_encode($result) ;
                exit;
            }elseif(isset($_POST['session']) && $_POST['session'] == 'true'){

                // $sql = "SELECT name, nicname, id, root, is_party, admit, post, password FROM users WHERE login = :login";
                $sql = "SELECT name, nicname, id, password FROM users WHERE login = :login";

                $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_EMAIL)??false;
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING)??false;

                $arr = Yii::$app->db->createCommand($sql)->bindValues([':login' => $login])->queryAll();
                if($password == $arr[0]['password']){
                        $_SESSION['login'] = $login;
                        $_SESSION['name'] = $arr[0]['name'];
                        $_SESSION['nicname'] = $arr[0]['nicname'];
                        $_SESSION['id'] = $arr[0]['id'];

                        // $_SESSION['admit'] = $arr[0]['admit'];
                        // $_SESSION['root'] = $arr[0]['root'];
                        // $_SESSION['is_party'] = $arr[0]['is_party'];
                        // $_SESSION['post'] = $arr[0]['post'];
                }
            }
    }
//
}
<?php
namespace app\controllers\admin;
use Yii;
use app\models\News;
use app\models\Post;
use app\models\User;
use app\models\PostVk;
use app\models\KosList;
use app\models\Profation;
use yii\web\UploadedFile;
use app\models\NavbarAdmin;
use app\controllers\AppController;

Class MainController extends AppController{
    public $layout = 'admin';
    public $user_root;
    // public $uri;
    public $vkParams;

    public function beforeAction($action){
        $this->vkParams = [
            'group_id' => '182016682',
            'token' => '4443368a0eac788c0ffa0d0ae7708eae0f908cb92b50d8e35450769c8797c78088084b396ac80baf91ffa',
            'client_id' => '6973346',
            'client_secret' => 'UZ177WIF0bu875PXb0j8',
        ];

        $this->user_root = Yii::$app->db->createCommand($this->user_root_sql)->bindValues([':id' => $_SESSION['id']])->queryAll()[0];
        $this->navbar = NavbarAdmin::find()->asArray()->all();
        
        if(!($this->user_root['root'] == 'admin' || $this->user_root['post'] == '5' || $this->user_root['post'] == '4')){
            return $this->redirect(['/']);
        }

        
        return parent::beforeAction($action);
    }
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionCreatNews(){
        $model = new News();
        if (Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post())){
                $model->creat_user_id =  $_SESSION['id'];
                $model->img = UploadedFile::getInstance($model, 'img');
                $model->date = date('Y-m-d H:i:s');
                if($model->validate()){
                    if(true){
                        // debug($_FILES);
                        if($_FILES['News']['name']['img']){
                            if($model->upload()){
                                if($model->save(false)){
                                    if(isset($_POST['chekVk'])){
                                        $postVk = new PostVk($this->vkParams, $model);
                                        // $postVk->pubNew(1);
                                    }
                                    Yii :: $app->session->setFlash('success', 'Данные приняты');
                                    return $this->refresh();
                                }
                                else{
                                    Yii :: $app->session->setFlash('error', '');
                                }
                            }
                        }
                        else{
                            if($model->save(false)){
                                if(isset($_POST['chekVk'])){
                                    $postVk = new PostVk($this->vkParams, $model);
                                    $postVk->pubNew(1);
                                }
                                Yii :: $app->session->setFlash('success', 'Данные приняты');
                                return $this->refresh();
                            }
                            else{
                                Yii :: $app->session->setFlash('error', '');
                            }
                        }
                    }
                    // if(isset($_POST['chekVk'])){ 
                    //     $postVk = new PostVk($this->vkParams, $model);
                    //     $postVk->pubNew(1);
                    // }
                }

            }
        }
        return $this->render('creat-news',compact('model'));
    }
    public function actionListUsers(){
        if( Yii :: $app->request->isAjax){
            if($_POST['output']){  //out us
                $id = $_SESSION['id'];
                $type = $_POST['type'];
                $params = $this->get_params()['us_params'];
                $params['prof'] = Profation::find()->asArray()->all();
                $params['post'] = Post::find()->asArray()->all();
                return $this->get_html_list(User::get_users(compact('id','type')), $params);
            }
            else{// update us
                $params =  $this->get_params()['query'];
                return User :: up_users($params);
            }
            exit;
        }
        return $this->render('list-users');
    }
    public function actionKos($id = null){
        if(!$id)
            $model = new KosList();
        else
            $model = KosList::findOne($id);
        if (Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post())){
                    $model->save(false);
                    if(!$id)
                        return $this->refresh();
                    else
                        return $this->redirect(['/admin/kos/']);
                }
            }
        $prof = Profation :: find()->asArray()->all();
        $kos = KosList :: find()->asArray()->all();
        return $this->render('kos',compact('model','prof','kos','id'));
    }
    
    public function get_params(){
        return[
            'query'=>[
                'type' => $_POST['type'],
                ':id' => $_POST['id'],
                ':root' => $_POST['root'],
                ':post' => $_POST['us_post'],
                ':admit' =>$_POST['admit'],
                ':party' => $_POST['party'],
            ],
            'us_params' =>[
                'roots' => [
                    'admin',
                    'user'
                ],
                'admit' => [
                    [
                        'id'=>'1',
                        'item_admit'=>'Есть'
                    ],
                    [
                        'id'=>'0',
                        'item_admit'=>'Нет'
                    ]
                ],
                'party' => [
                    [
                        'id'=>'0',
                        'item_party'=>'Гость'
                    ],
                    [
                        'id'=>'1',
                        'item_party'=>'Свой котик'
                    ]
                ],
            ]
        ];
    }
    public function get_html_list($arr,$params){
        $html = 
        
            '<div class="row">
                <div name="nicname" class="tb-title col-3 border border-success border-bottom-0 bg-dark">Ник игрока</div>
                <div name="authority"class="tb-title col-2 border border-success border-bottom-0 bg-dark border-left-0">Полномочия</div>
                <div name="post"class="tb-title col-3 border border-success border-bottom-0 bg-dark border-left-0">Должность</div>
                <div name="admit"class="tb-title col-2 border border-success border-bottom-0 bg-dark border-left-0">Допуск к сайту</div>
                <div name="is_party"class="tb-title col-2 border border-success border-bottom-0 bg-dark border-left-0">Учасник клана</div>
            </div>';

        foreach($arr as $item) :
            $html .= '
            <div class="row" name="item"  id="' . $item["id"] . '">

                <div data-toggle="tooltip" data-placement="top" title="';
                    foreach($params['prof'] as $item_prof) :
                        if($item['prof_id'] == $item_prof['id']) {
                            $html .= $item["name"].'<br>'.$item_prof["prof_name"];
                        }
                    endforeach;
                    $html .='" id="' . $item['id'] . '" class="col-3 p-2 border border-success border-bottom-0">'
                    . $item['nicname'] .
                '</div>';

                    $html .='

                <div class="list-cont col-2">';
                    if($this->user_root['root'] === 'admin'){
                        $html .= '
                            <select name="root" id="' . $item['id'] . '" class="list-item">';
                                foreach($params['roots'] as $root){

                                    $html .='
                                    <option '; if($item['root'] == $root){ $html .= ' selected ';} $html.= 'value="' . $root . '" class="content">'
                                                    . $root .
                                    '</option>';
                                }
                                    $html .=
                            '</select>';
                    }
                    else{
                        $html .= '<div class="border  border-bottom-0 px-1 border-left-0 w-100">' . $item['root'] . '</div>';
                    }
                    $html .=
                '</div>';

                    $html .=
                '<div class="list-cont col-3">
                    <select name="us_post" id="' . $item['id'] . '" class="list-item">';
                        foreach($params['post'] as $item_post):
                                $html .= '
                            <option value="' . $item_post['id'] . '" class="content"';
                                if($item_post['id'] == $item['post_id']){
                                    $html .= 'selected';
                                }
                                $html .= '>' .
                                $item_post['item_post'] .
                            '</option>';
                        endforeach;
                        $html .=
                    '</select>
                </div>

                <div class="col-2 list-cont">
                    <select name="admit" id="' . $item['id'] . '" class="list-item">';
                        foreach($params['admit'] as $item_admit):
                                $html .=
                            '<option value="' . $item_admit['id'] . '" class="content"';
                                if($item_admit['id'] == $item['admit']){
                                    $html .= 'selected';
                                }
                                    $html .=
                                '>' .
                                    $item_admit['item_admit']  .
                            '</option>';
                        endforeach;
                        $html .= '
                    </select>
                </div>

                <div class="col-2 list-cont">
                    <select name="party" id="' . $item['id'] . '" class="list-item">';
                        foreach($params['party'] as $item_party):
                                $html .=
                            '<option value="' . $item_party['id'] . '" class="content"';
                                if($item_party['id'] == $item['is_party']){
                                    $html .= 'selected';
                                }
                                $html .='>' .
                                    $item_party['item_party'] .
                            '</option>';
                        endforeach;
                            $html .=
                    '</select>
                </div>
                <input type="checkbox" class="d-none" id="' . $item['id'] . '">

            </div>';
        endforeach;
        return $html;
    }
    public function getCrul($url,$get_params = null){
        $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL,$url . $get_params);
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
            // curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
            $result = curl_exec($curl_handle);
        curl_close($curl_handle);
    return json_decode($result);
    }
}

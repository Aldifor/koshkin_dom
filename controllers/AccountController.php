<?php
namespace app\controllers;
use Yii;
// use app\models\User;
use app\models\Navbar;
use yii\web\Controller;
use app\models\Profation;
use app\models\ChangePassword;

Class AccountController extends AppController{
    public function beforeAction($action){

        $this->navbar = Navbar::find()->asArray()->all();

        return parent::beforeAction($action);
    }
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionRegister(){
        if( Yii :: $app->request->isAjax){
            $sql = 'SELECT login FROM users WHERE login = :login';
            if(isset($_POST['logtest'])){
                
                $logtest = htmlspecialchars($_POST['logtest']);
                $result = Yii::$app->db->createCommand($sql)->bindValues([':login' => $logtest])->queryAll();
                echo json_encode($result);
                exit;
            }
            $login = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $nicname = filter_input(INPUT_POST, 'nic', FILTER_SANITIZE_STRING);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $idProf = filter_input(INPUT_POST, 'prof', FILTER_SANITIZE_STRING);
            $pas = filter_input(INPUT_POST, 'pas', FILTER_SANITIZE_STRING);
            $pas_rep = filter_input(INPUT_POST, 'pas_rep', FILTER_SANITIZE_STRING);
            if($pas == $pas_rep && !Yii::$app->db->createCommand($sql)->bindValues([':login' => $login])->execute()){
            // if(true){
                $sql_insert = "INSERT INTO users (nicname, name, login, password, email, profation)VALUE (:nicname, :name, :login, :password, :email, :profation)";
                $params = [
                    ':nicname' =>$nicname,
                    ':name' =>$name,
                    ':login' =>$login,
                    ':password' =>$pas,
                    ':email' =>$login,
                    ':profation' =>$idProf,
                ];
                Yii::$app->db->createCommand($sql_insert)->bindValues($params)->execute();

                Yii::$app->mailer->compose()
                    ->setTo(Yii::$app->params['adminEmail'])
                    ->setFrom([Yii::$app->params['siteEmail'] => 'КошкинДом'])
                    ->setSubject('Новый пользователь')
                    ->setTextBody('Ник: '.$nicname)
                    ->send();
            }else{
                echo 'Ошибка валидации';
            }
        
            
            exit;
        }
        $this->layout = 'register';
        $prof = Profation::find()->asArray()->all();
        return $this->render('register',compact('prof'));
    }
    public function actionChangePassword(){
        $model = new ChangePassword();
        if($model->load($_POST)){
            if($model->changePassword()){
                Yii :: $app->session->setFlash('success', 'Пороль успешно изменнен');
                return $this->refresh();
            }
            else{
                Yii :: $app->session->setFlash('error', 'Старый пороль не верен');
            }
        }
        return $this->render('change-password',compact('model'));
    }
}
?>
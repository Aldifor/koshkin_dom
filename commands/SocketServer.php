<?php
namespace app\commands; 
use Yii;
use app\models\Chat;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class SocketServer implements MessageComponentInterface
{
    protected $clients;
    private $comfirm = [];
    private $chat_user = [];
    public function __construct()
    {
        error_reporting(0);

        $this->clients = new \SplObjectStorage; // Для хранения технической информации об присоединившихся клиентах используется технология SplObjectStorage, встроенная в PHP
    }
   
    public function onOpen(ConnectionInterface $conn)
    {
        if(!Yii::$app->db->isActive){
            Yii::$app->db->open();
        }
        $this->clients->attach($conn);
        echo "New connection! ".$conn->resourceId;
    }

    public function onMessage(ConnectionInterface $from, $data)
    {
        if(!Yii::$app->db->isActive){
            Yii::$app->db->open();
        }
        $numRecv = count($this->clients) - 1;
        $data = json_decode($data,true);

        print_r($data);
        
        if(isset($data['dialog']) && $data['dialog']){
            $answer = Chat::getMessage($data);
            foreach ($this->clients as $client) {
                if ($from == $client) {
                    $client->send($answer);
                }
            }
        }else{

            if($data['init']){
                $this->confirm[$from->resourceId] = $data['us_id'];
                $this->chat_user[$from->resourceId] = $data ['type'];
                $answer = Chat::getMessage($data);
                foreach ($this->clients as $client) {
                    if ($from == $client) {
                        $client->send($answer);
                    }
                }
            }
            else{
                $data['us_id'] = $this->confirm[$from->resourceId];
                $answer = Chat::getMessage($data);
                echo $answer;
                foreach ($this->clients as $client) {
                    if($this->chat_user[$client->resourceId] == $data['type'])
                        $client->send($answer);
                }
            }
        }
        
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        unset($this->confirm[$conn->resourceId]);
        unset($this->chat_user[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";

    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
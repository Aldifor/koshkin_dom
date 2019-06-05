<?php
namespace app\commands; 
use app\models\Chat;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class SocketServer implements MessageComponentInterface
{
    protected $clients;
    private $comfirm = [];
    public function __construct()
    {
        $this->clients = new \SplObjectStorage; // Для хранения технической информации об присоединившихся клиентах используется технология SplObjectStorage, встроенная в PHP
    }
   
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ".$conn->resourceId.", сессия: ".$_SESSION['id']."\n";
    }

    public function onMessage(ConnectionInterface $from, $data)
    {
        $numRecv = count($this->clients) - 1;
        $data = json_decode($data,true);

        print_r($data);
        if($data['dialog']){
            $answer = Chat::getMessage($data);
            foreach ($this->clients as $client) {
                if ($from == $client) {
                    $client->send($answer);
                }
            }
        }else{

            if($data['init']){
                $this->confirm[$from->resourceId] = $data['us_id'];
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
                    $client->send($answer);
                }
            }
        }
        
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        unset($this->confirm[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";

    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
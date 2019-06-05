<?php
namespace app\commands;

 
use yii\console\Controller;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use app\commands\SocketServer;
use Ratchet\WebSocket\WsServer;

class SocketController extends  Controller
{
    public function actionStartSocket($port=5432)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketServer()
                )
            ),
            $port
        );
        $server->run();
    }
}
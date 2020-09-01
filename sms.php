<?php
    include "vendor/autoload.php";

    $clients = new SMSGatewayMe\Client\ClientProvider("your-token-here");

    $sendMessageRequest = new SMSGatewayMe\Client\Model\SendMessageRequest([
        'phoneNumber' => '0041787720815', 'message' => 'hello world', 'deviceId' => 1
    ]);

    $sentMessages = $clients->getMessageClient()->sendMessages([$sendMessageRequest]);
       
       ?>                     
<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class NotificationClass{

    public function __construct(){
        
    }

    public function saveNotification($client, $title, $message, $type, $status){
        $SQL = new SQLCommands("mercedes_ois");
        
        $parameters = [
            "title" => $title,
            "message" => $message,
            "type" => $type,
            "status" => $status
        ];

    $result = $SQL->InsertQuery("notifications", $parameters);
    return $result;
    }
    
}

?>
<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class SampleClass{

    public function __construct(){
        
    }

    public function getData($client){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM user_accounts
                WHERE client = '$client'";
        $result = $SQL->SelectQuery($query);
        return $result;
    }
    
}

?>
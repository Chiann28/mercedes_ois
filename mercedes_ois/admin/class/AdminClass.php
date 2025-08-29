<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class AdminClass{

    public function __construct(){
        
    }

    public function DoLogin($client, $username, $password){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM user_accounts
                WHERE client = '$client'
                AND username = '$username'
                AND `password` = '$password'
                LIMIT 1";
        $result = $SQL->SelectQuery($query);

        
        
        if (empty($result) || count($result) == 0) {
            return [
                "result"   => false,
                "message"  => "Invalid Username or Password",
                "username" => $username
            ];
        }

        $user = $result[0];

        if (isset($user['role']) && strtolower($user['role']) === "admin") {
            return [
                "result"   => true,
                "message"  => "Login successful",
                "username" => $username,
                "role"     => "admin"
            ];
        } else {
            return [
                "result"   => true,
                "message"  => "Login successful",
                "username" => $username,
                "role"     => $user['role'] ?? "user"
            ];
        }

    }
    
}

?>
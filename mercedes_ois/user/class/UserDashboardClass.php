<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";


class UserDashboardClass{

    public function __construct(){
        
    }

    public function GetUserData($client, $user_id) {
        $SQL = new SQLCommands("mercedes_ois");

        $query = "SELECT cd.* FROM user_accounts u
                    LEFT JOIN customer_details cd
                    ON cd.client = u.client
                    AND cd.accountnumber = u.accountnumber
                                    WHERE u.client = '$client'
                                    AND u.user_id = '$user_id'";
        $result = $SQL->SelectQuery($query);

        return $result[0];
    }

   
    
}

?>
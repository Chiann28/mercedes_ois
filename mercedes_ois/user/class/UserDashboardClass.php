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
        
        // print_r($query);
        $result = $SQL->SelectQuery($query);

        return $result[0];
        // print_r($result);
    }

    public function get_transaction_history($client, $user_id) {
        $SQL = new SQLCommands("mercedes_ois");

        $query = "SELECT cd.* FROM user_accounts u
                    LEFT JOIN customer_details cd
                    ON cd.client = u.client
                    AND cd.accountnumber = u.accountnumber
                                    WHERE u.client = '$client'
                                    AND u.user_id = '$user_id'";
        $result = $SQL->SelectQuery($query);
        $accountnumber = $result[0]['accountnumber'];

        $query2 = "SELECT * FROM balance_sheet WHERE client = '$client'
                    AND accountnumber = '$accountnumber'
                    ORDER BY transaction_date_time DESC";
         $result2 = $SQL->SelectQuery($query2);        
        return $result2;
    }

    public function GetArrears($client, $accountnumber) {
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT balance FROM balance_sheet WHERE client = '$client' 
        AND accountnumber = '$accountnumber' ORDER BY sysentrydate DESC LIMIT 1
        ";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function GetNotifications($accountnumber = null) {
        $SQL = new SQLCommands("mercedes_ois");
    
        //Global notifications (Reminder, Bill, Announcement)
        $query = "
            SELECT n.* 
            FROM notifications n
            WHERE n.type IN ('Reminder', 'Bill', 'Announcement')
            AND NOT EXISTS (
                SELECT 1 
                FROM notification_users nu
                WHERE nu.notification_id = n.id
                  AND nu.accountnumber = '$accountnumber'
            )
        ";
        $result = $SQL->SelectQuery($query);
    
        // 🔹 Specific notifications (Request, Update, etc.)
        $result2 = [];
        if (!empty($accountnumber)) {
            $query2 = "
                SELECT n.*
                FROM notifications n
                WHERE n.type NOT IN ('Reminder', 'Bill', 'Announcement')
                  AND n.accountnumber = '$accountnumber'
                  AND NOT EXISTS (
                      SELECT 1 
                      FROM notification_users nu
                      WHERE nu.notification_id = n.id
                        AND nu.accountnumber = '$accountnumber'
                  )
            ";
            $result2 = $SQL->SelectQuery($query2);
        }
    
        $merged = array_merge($result, $result2);
        return $merged;
    }
    

    public function MarkAsRead($id, $accountnumber, $user_id){
        $SQL = new SQLCommands("mercedes_ois");
        
        $parameters = [
            'notification_id' => $id,
            'user_id' => $user_id,
            'accountnumber' => $accountnumber,
            'status' => "read"
        ];
        
        $result = $SQL->InsertQuery('notification_users', $parameters);
        
        return $result;
    }
    

   
    
}

?>
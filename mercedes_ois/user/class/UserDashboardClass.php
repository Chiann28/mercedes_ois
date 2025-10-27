<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";


class UserDashboardClass
{

    public function __construct()
    {

    }

    public function GetUserData($client, $user_id)
    {
        $SQL = new SQLCommands("mercedes_ois");

        $query = "SELECT cd.*, u.is_otp FROM user_accounts u
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

    public function get_transaction_history($client, $user_id)
    {
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

    public function GetArrears($client, $accountnumber)
    {
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT balance FROM balance_sheet WHERE client = '$client' 
        AND accountnumber = '$accountnumber' ORDER BY sysentrydate DESC LIMIT 1
        ";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function GetNotifications($accountnumber = null)
    {
        $SQL = new SQLCommands("mercedes_ois");

        //Global notifications (Reminder, Bill, Announcement)
        $query = "SELECT n.*, 
                        'unread' as `n_status`, 
                         CONCAT(DATE_FORMAT(n.created_at, '%b %e %h:%i '), LOWER(DATE_FORMAT(n.created_at, '%p'))) AS formatted_datetime
  
                    FROM notifications n
                    WHERE n.type IN ('Reminder', 'Bill', 'Announcement')
                    AND NOT EXISTS (
                        SELECT 1 
                        FROM notification_users nu
                        WHERE nu.notification_id = n.id
                        AND nu.accountnumber = '$accountnumber'
                        ORDER BY n.created_at DESC
                    )
        ";
        $result = $SQL->SelectQuery($query);

        // Specific notifications (Request, Update, etc.)
        $result2 = [];
        $resultReadSpecific = [];
        if (!empty($accountnumber)) {
            // unread specific notifs
            $query2 = " SELECT n.*, 
                        'unread' as `n_status`,
                         CONCAT(DATE_FORMAT(n.created_at, '%b %e %h:%i '), LOWER(DATE_FORMAT(n.created_at, '%p'))) AS formatted_datetime
                        
                        FROM notifications n
                        WHERE n.type NOT IN ('Reminder', 'Bill', 'Announcement')
                        AND n.accountnumber = '$accountnumber'
                        AND NOT EXISTS (
                            SELECT 1 
                            FROM notification_users nu
                            WHERE nu.notification_id = n.id
                                AND nu.accountnumber = '$accountnumber'
                            ORDER BY n.created_at DESC)
            ";
            $result2 = $SQL->SelectQuery($query2);

            //read specific notifs
            $queryReadSpecificNotifs = "SELECT n.*, 
            'read' as `n_status`,
             CONCAT(DATE_FORMAT(n.created_at, '%b %e %h:%i '), LOWER(DATE_FORMAT(n.created_at, '%p'))) AS formatted_datetime 
                            FROM notifications n
                            WHERE n.type NOT IN ('Reminder', 'Bill', 'Announcement')
                            AND n.accountnumber = '$accountnumber'
                            AND EXISTS (
                                SELECT 1 
                                FROM notification_users nu
                                WHERE nu.notification_id = n.id
                                    AND nu.accountnumber = '$accountnumber'
                                    ORDER BY n.created_at DESC)";
            $resultReadSpecific = $SQL->SelectQuery($queryReadSpecificNotifs);
        }

        //read global notifs
        $queryReadGlobal = "SELECT n.*, 'read' as `n_status`,
        CONCAT(DATE_FORMAT(n.created_at, '%b %e %h:%i '), LOWER(DATE_FORMAT(n.created_at, '%p'))) AS formatted_datetime  
                            FROM notifications n
                            WHERE n.type IN ('Reminder', 'Bill', 'Announcement')
                            AND EXISTS (
                                SELECT 1 
                                FROM notification_users nu
                                WHERE nu.notification_id = n.id
                                AND nu.accountnumber = '$accountnumber'
                                ORDER BY n.created_at DESC)";
        $resultReadGlobal = $SQL->SelectQuery($queryReadGlobal);

        $merged = array_merge($result, $result2, $resultReadSpecific, $resultReadGlobal);
        return $merged;
    }


    public function MarkAsRead($id, $accountnumber, $user_id)
    {
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


    public function DoUpdatePassword($client, $accountnumber, $password)
    {
        // Validate password before updating
        if (!$this->isValidPassword($password)) {
            return array(
                "success" => false,
                "message" => "Password must be at least 8 characters long, contain at least one uppercase letter, and one number."
            );
        }

        $SQL = new SQLCommands("mercedes_ois");

        // Escape values to prevent SQL injection (better if you use prepared statements)
        $client = addslashes($client);
        $accountnumber = addslashes($accountnumber);
        $password = addslashes($password);

        $query = "
        UPDATE user_accounts
        SET password = '$password', is_otp = '0'
        WHERE client = '$client'
        AND accountnumber = '$accountnumber'
        ";

        $result = $SQL->UpdateQuery($query);
        return array("success" => $result);
    }

    private function isValidPassword($password)
    {
        // At least 8 chars, 1 uppercase, 1 number
        $pattern = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';
        return preg_match($pattern, $password);
    }




}

?>
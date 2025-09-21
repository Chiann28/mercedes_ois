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

    //auto posting of announcements
    public function DoAutoPostAnnouncement($client){
        $SQL = new SQLCommands("mercedes_ois");
        $date = date('Y-m-d');

        $query = "SELECT announcement_no FROM announcements
                    WHERE client = '$client'
                    AND scheduled_date <= '$date'
                    AND status = 'SCHEDULED'";
        $result = $SQL->SelectQuery($query);

        if ($result && count($result) > 0) {
            foreach ($result as $row) {
                $announcement_no = $row['announcement_no'];
    
                $update = "UPDATE `announcements` 
                            SET `status` = 'POSTED'
                            WHERE client = '$client'
                            AND announcement_no = '$announcement_no'";
                $SQL->UpdateQuery($update);
            }
            return true;
        }
    
        return false;
    }

    public function DoGetEventDashboard($client) {
        $SQL = new SQLCommands("mercedes_ois");
        $date = date('Y-m-d');

        $query = "SELECT *, date(start_date) as `date_start`
         FROM events WHERE date(start_date) >= '$date' ORDER BY start_date LIMIT 3";
        $result = $SQL->SelectQuery($query);

        return $result;
    }
    
}

?>
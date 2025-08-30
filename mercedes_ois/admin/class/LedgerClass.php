<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class LedgerClass{

    public function __construct(){
        
    }

    public function GetAccountList($client, $accountnumber){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM customer_details
                WHERE client = '$client'
               AND (
                  accountnumber LIKE '%$accountnumber%'
                  OR firstname LIKE '%$accountnumber%'
                  OR lastname LIKE '%$accountnumber%'
              )";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function GetAccountDetails($client, $accountnumber){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT *, DATE(sysentrydate) AS date_registered FROM customer_details
                WHERE client = '$client'
                AND accountnumber = '$accountnumber'";
        $result = $SQL->SelectQuery($query);
        return $result[0];
    }

   

    public function GetTransactionHistory($client, $accountnumber){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM transactions
                WHERE client = '$client'
                AND accountnumber = '$accountnumber'
                AND transaction_type NOT IN ('Adjustments')
                ORDER BY sysentrydate ASC";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function GetAdjustments($client, $accountnumber){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM adjustments
                WHERE client = '$client'
                AND accountnumber = '$accountnumber'
                AND adjustment_status = 'adjusted'
                ORDER BY sysentrydate ASC";
        $result = $SQL->SelectQuery($query);
        return $result;
    }
    
}

?>
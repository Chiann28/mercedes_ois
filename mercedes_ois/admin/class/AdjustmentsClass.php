<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class AdjustmentsClass{

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
        $query = "SELECT * FROM transactions
                WHERE client = '$client'
                AND accountnumber = '$accountnumber'
                AND transaction_type = 'Adjustments'
                ORDER BY sysentrydate ASC";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function SaveAdjustment($params, $user){
        $SQL = new SQLCommands("mercedes_ois");
        $transaction_id = isset($params['transaction_id']) ? $params['transaction_id'] : NULL; 
        $amount = isset($params['adjustment_amount']) ? $params['adjustment_amount'] : NULL; 
        $remarks = isset($params['remarks']) ? $params['remarks'] : NULL; 
        $client = isset($params['client']) ? $params['client'] : NULL;
        $accountnumber = isset($params['accountnumber']) ? $params['accountnumber'] : NULL;

        $item = $this->GetDataTransaction($client, $transaction_id);

        $query = "UPDATE `transactions` SET 
                    amount_paid = '$amount',
                    adjustments = '$amount'
                    WHERE client = '$client'
                    AND transaction_id = '$transaction_id'";
       
        $result = $SQL->UpdateQuery($query);

        $adjustment = $this->DoInsertAdjustments($client, $accountnumber, $transaction_id, $amount, $item['amount_paid'], $remarks, $user);
       
       if($adjustment){
            return ["result" => true, "message" => "Successfully Adjusted", "adjusted" => $adjustment];
       }
    }

    public function DoInsertAdjustments($client, $accountnumber, $transaction_id, $amount, $previous_amount, $remarks, $user){
        $SQL = new SQLCommands("mercedes_ois");
        $current_date = date('YmdHis');
        $parameters = [
            "id" => $transaction_id.$current_date,
            "client" => $client,
            "accountnumber" => $accountnumber,
            "reference" => $transaction_id,
            "adjustment_status" => "adjusted",
            "amount" => $amount,
            "previous_amount" => $previous_amount,
            "remarks" => $remarks,
            "modifiedby" => $user
        ];

        $insert = $SQL->InsertQuery("adjustments", $parameters);
        return $insert;
    }

    public function GetDataTransaction($client, $transaction_id){
        $SQL = new SQLCommands("mercedes_ois");
        
        $query = "SELECT * FROM transactions
                    WHERE client = '$client'
                    AND transaction_id = '$transaction_id'
                    ORDER BY sysentrydate DESC LIMIT 1";
        $result = $SQL->SelectQuery($query);

        return $result[0];
    }
    
}

?>
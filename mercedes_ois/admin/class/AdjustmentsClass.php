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
        $query = "SELECT * ,
                CASE
                    WHEN status = 'true' THEN 'Paid'
                    ELSE 'Invalid'
                END as status
                FROM balance_sheet
                WHERE client = '$client'
                AND accountnumber = '$accountnumber'
                AND transaction_type = 'Payment'
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

        $item = $this->GetCreditAdjustment($client, $transaction_id);
        $credit = $item['credit'];
        $transaction_reference = "ADJ".$accountnumber.date('YmdHis');

        $get_latest_balance = "SELECT balance FROM balance_sheet
        WHERE client = '$client' AND 
        accountnumber = '$accountnumber'
        ORDER BY transaction_date_time DESC 
        LIMIT 1";

        $fetch = $SQL->SelectQuery($get_latest_balance);
        $latest_balance = isset($fetch[0]['balance']) ? $fetch[0]['balance'] : 0;

        if($amount > 0){
            $credit = $amount;
            $debit = 0;
            $balance = $latest_balance + $amount;
        }
        elseif($amount < 0){
            $debit = ABS($amount);
            $credit = 0;
            $balance = $latest_balance - ABS($amount);
        }
        else{
            return ["result" => false, "message" => "No changes", "not adjusted" => $adjustment];
        }

        $parameters = [
            "client" => $client,
            "accountnumber" => $accountnumber,
            "transaction_date" => date('Y-m-d'),
            "transaction_type" => "Adjustment",
            "classification" => "Billing",
            "transaction_reference" => $transaction_reference,
            "debit" => $debit,
            "credit" => $credit,
            "balance" => $balance,
            "transaction_date_time" => date('Y-m-d H:i:s'),
            "status" => "true",
            "modifiedby" => $user
        ];

        $insert = $SQL->InsertQuery("balance_sheet", $parameters);
       
        $transaction = $this->DoInsertTransaction($client, $accountnumber, $transaction_reference, $amount, $user);

        $adjustment = $this->DoInsertAdjustments($client, $accountnumber, $transaction_id, $amount, $remarks, $user);
       
       if($insert && $transaction && $adjustment){
            return ["result" => true, "message" => "Successfully Adjusted", "adjusted" => $adjustment];
       }
       else{
            return ["result" => false, "message" => "Unsuccessfully Saved", "not adjusted" => $adjustment];
       }
    }

    public function DoInsertTransaction($client,$accountnumber, $transaction_reference, $amount, $modifiedby){
        $SQL = new SQLCommands("mercedes_ois");
        $classification = "adjustments";
        $transaction_type = "Adjustments";
        $source = "collection";

        if($amount > 0){
            $amount_paid = $amount;
            $overpayment = NULL;
        }
        elseif($amount < 0){
            $amount_paid = NULL;
            $overpayment = ABS($amount);
        }

        $parameters = [
            "client" => $client,
            "transaction_id" => $transaction_reference,
            "accountnumber" => $accountnumber,
            "amount_paid" => $amount_paid,
            "status" => "paid",
            "classification" => $classification,
            "transaction_type" => $transaction_type,
            "transaction_date" => date('Y-m-d'),
            "overpayment" => $overpayment,
            "source" => $source,
            "modifiedby" => $modifiedby
        ];

        $result = $SQL->InsertQuery("transactions", $parameters);
        return $result;
    }

    public function DoInsertAdjustments($client, $accountnumber, $transaction_id, $amount, $remarks, $user){
        $SQL = new SQLCommands("mercedes_ois");
        $current_date = date('YmdHis');
        $parameters = [
            "id" => $transaction_id.$current_date,
            "client" => $client,
            "accountnumber" => $accountnumber,
            "reference" => $transaction_id,
            "adjustment_status" => "adjusted",
            "amount" => $amount,
            "remarks" => $remarks,
            "modifiedby" => $user
        ];

        $insert = $SQL->InsertQuery("adjustments", $parameters);
        return $insert;
    }

    public function GetCreditAdjustment($client, $transaction_id){
        $SQL = new SQLCommands("mercedes_ois");
        
        $query = "SELECT * FROM balance_sheet
                    WHERE client = '$client'
                    AND transaction_reference = '$transaction_id'
                    ORDER BY sysentrydate DESC LIMIT 1";
        // echo $query;
        $result = $SQL->SelectQuery($query);
        return $result[0];
    }
    
}

?>
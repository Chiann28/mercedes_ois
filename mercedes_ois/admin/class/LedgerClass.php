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
        $query = "SELECT *,
                DATE_FORMAT(transaction_date_time, '%M %e, %Y - %h:%i %p') AS date_processed,
                DATE_FORMAT(transaction_date, '%M %e, %Y') AS transaction_date,
                DATE_FORMAT(DATE_ADD(transaction_date_time, INTERVAL 1 MONTH), '%M %e, %Y') AS due_date
                 FROM balance_sheet
                WHERE client = '$client'
                AND accountnumber = '$accountnumber'
                ORDER BY transaction_date_time ASC";
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

    public function VerifyRates($client, $user){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT MAX(transaction_date) as max_date 
                    FROM balance_sheet
                    WHERE client = '$client'
                    AND transaction_type = 'Bill'";
        $result = $SQL->SelectQuery($query);
    
        $currentMonth = date('Ym');
        $lastMonth = isset($result[0]['max_date']) ? date('Ym', strtotime($result[0]['max_date'])) : null;
    
        if($lastMonth === $currentMonth){
            return [
                "result" => false,
                "message" => "Bills are already generated for this month."
            ];
        }
    
        return [
            "result" => true,
            "message" => "No bills yet for this month, ready to generate."
        ];
    }

    public function DoGenerateBill($client, $user){
        
        $verify = $this->VerifyRates($client, $user);
        if(!$verify['result']){
            return $verify;
        }

        $month = date('F Y');
    
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT p.*, r.price, r.penalty_rate 
                    FROM properties p 
                    LEFT JOIN ref_properties r
                    ON r.client = p.client
                    AND r.property_code = p.property_code
                    WHERE p.client = '$client'";
        $datas = $SQL->SelectQuery($query);

        //Generated month table
        $generated_bill_params = [
            "client" => $client,
            "generated_month" => $month,
            "status" => 1,
            "modifiedby" => $user
        ];

        $insert2 = $SQL->InsertQuery("generated_bill", $generated_bill_params);
    
        $inserted = [];
        $failed = [];
    
        foreach($datas as $data){
            $price = $data['price'];
            $accountnumber = $data['accountnumber'];
            $surcharge = $data['penalty_rate'];
    
            $get_latest_balance = "SELECT balance FROM balance_sheet
                                    WHERE client = '$client' AND 
                                    accountnumber = '$accountnumber'
                                    ORDER BY transaction_date_time DESC 
                                    LIMIT 1";
            $fetch = $SQL->SelectQuery($get_latest_balance);
            $latest_balance = isset($fetch[0]['balance']) ? $fetch[0]['balance'] : 0;
    
            $transaction_reference = $accountnumber . date('Ym');
    
            // Insert
            $parameters = [
                "client" => $client,
                "accountnumber" => $accountnumber,
                "transaction_date" => date('Y-m-d'),
                "transaction_type" => "Bill",
                "classification" => "Billing",
                "transaction_reference" => $transaction_reference,
                "debit" => $price,
                "balance" => $latest_balance + $price,
                "transaction_date_time" => date('Y-m-d H:i:s'),
                "status" => "false",
                "modifiedby" => $user
            ];
    
            $insert = $SQL->InsertQuery("balance_sheet", $parameters);
    
            if($insert){
                $inserted[] = $accountnumber;
            } else {
                $failed[] = $accountnumber;
            }
        }

    
        return [
            "result" => true,
            "message" => "Bill generation completed.",
            "success" => count($inserted),
            "failed" => count($failed),
            "inserted_accounts" => $inserted,
            "failed_accounts" => $failed
        ];
    }

    public function GetGeneratedBill($client){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM generated_bill
                WHERE client = '$client'
                ORDER BY sysentrydate ASC";
        $result = $SQL->SelectQuery($query);
        return $result;
    }
    
    
}

?>
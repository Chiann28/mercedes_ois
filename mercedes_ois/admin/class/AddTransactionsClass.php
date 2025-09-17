<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class AddTransactionsClass{

    public function __construct(){
        
    }

    public function GetAccountList($client){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM customer_details
                WHERE client = '$client'";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function DoPostPayment($params, $user){
        $SQL = new SQLCommands("mercedes_ois");

        $client = $params['client'];
        $transaction_type = $params['transaction_type'];

        switch($transaction_type){
            case "ADV":
                $transaction_id = "ADVV".$params['accountnumber'].date('YmdHis');
            break;

            case "MISC":
                $transaction_id = "MISC".$params['accountnumber'].date('YmdHis');
            break;

            default:
                $transaction_id = "PAYMENT".$params['accountnumber'].date('YmdHis');
            break;
            
        }

        
        $accountnumber = $params['accountnumber'];
        $amount_paid = $params['amount_paid'];
        // $status = $params['status'];
        $transaction_date = date('Y-m-d');
        $source = "collection";
        $modifiedby = $user;

        switch($transaction_type){
            case "ADV":
                $transaction_type = "Advance Payment";
                $classification = "advance payment";
            break;

            case "MISC":
                $transaction_type = "Miscellaneous";
                $classification = "normal payment";
            break;

            default:
              $transaction_type = "Cash";
            $classification = "normal payment";
            break;
            
        }

        $parameters = [
            "client" => $client,
            "transaction_id" => $transaction_id,
            "accountnumber" => $accountnumber,
            "amount_paid" => $amount_paid,
            "status" => "paid",
            "classification" => $classification,
            "transaction_type" => $transaction_type,
            "transaction_date" => $transaction_date,
            "source" => $source,
            "modifiedby" => $modifiedby
        ];

        $result = $SQL->InsertQuery("transactions", $parameters);

        if($result){
            $this->DoPostToLedger($client, $accountnumber, $amount_paid, $transaction_id, $transaction_date, $modifiedby);
            return [
                "result" => true,
                "message" => "Successfully Posted",
                "transaction_id" => $transaction_id
            ];
        }
        
        return [
            "result" => false,
            "message" => "Unsuccessfully Posted",
            "transaction_id" => $transaction_id
        ];
    }

    public function GetLatestTransactions($client, $accountnumber){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM transactions
                WHERE client = '$client'
                AND accountnumber = '$accountnumber'
                ORDER BY sysentrydate DESC LIMIT 1";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function SaveAttachment($client, $accountnumber, $transaction_id, $fileName, $filePath, $file_type, $file_size, $user){
        $SQL = new SQLCommands("mercedes_ois");

        $params = [
            "client" => $client,
            "accountnumber" => $accountnumber,
            "document_code" => $transaction_id,
            "type" => "Payment Proof",
            "description" => "Uploaded through POP",
            "filename" => $fileName,
            "filetype" => $file_type,
            "filesize" => $file_size,
            "filepath" => $filePath,
            "status" => 1,
            "modifiedby" => $user
        ];

        $result = $SQL->InsertQuery("requirements", $params);
        return $result;
    }

    public function DoPostToLedger($client, 
                                    $accountnumber, 
                                    $amount_paid, 
                                    $transaction_id, 
                                    $transaction_date, 
                                    $modifiedby)
        {
            $SQL = new SQLCommands("mercedes_ois");

            $get_latest_balance = "SELECT balance FROM balance_sheet
                                    WHERE client = '$client' AND 
                                    accountnumber = '$accountnumber'
                                    ORDER BY transaction_date_time DESC 
                                    LIMIT 1";
            $fetch = $SQL->SelectQuery($get_latest_balance);
            $latest_balance = isset($fetch[0]['balance']) ? $fetch[0]['balance'] : 0;

            $parameters = [
                "client" => $client,
                "accountnumber" => $accountnumber,
                "transaction_date" => $transaction_date,
                "transaction_type" => "Payment",
                "classification" => "Billing",
                "transaction_reference" => $transaction_id,
                "credit" => $amount_paid,
                "balance" => $latest_balance - $amount_paid,
                "transaction_date_time" => date('Y-m-d H:i:s'),
                "status" => "true",
                "modifiedby" => $modifiedby
            ];

            $insert = $SQL->InsertQuery("balance_sheet", $parameters);

            return $insert;

        }
    
}

?>
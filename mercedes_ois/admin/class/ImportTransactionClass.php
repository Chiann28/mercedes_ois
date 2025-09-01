<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class ImportTransactionClass{

    public function __construct(){
        
    }

    public function ImportTransactions($client, $params, $date, $user){
        $SQL = new SQLCommands("mercedes_ois");
        $date = date('Y-m-d', strtotime($date));
        $client = "mercedes";
    
        $success = 0;
        $fail = 0;
        $success_data = [];
        $fail_data = [];
    
        $response = [
            "result" => false,
            "message" => "Oops, something went wrong. Please try again later.",
            "data" => []
        ];
    
        for ($i = 0; $i < count($params); $i++) {
            $row = $params[$i];
            if (empty($row) || count($row) < 6) {
                continue;
            }
    
            $accountNumber = $row[0];
            $reference = $row[1];
            $amountPaid = $row[2];
            $transactionType = $row[3];
            $source = $row[4];
            $remarks = $row[5];
    
            $check_if_exist = $this->CheckAccount($client, $accountNumber);
    
            if (count($check_if_exist) == 0) {
                $fail++;
                $row[3] = "Account Number is not existing!";
                $row[4] = false;
                $fail_data[] = $row;
            } else {
                $parameters = [
                    'client' => $client,
                    'accountnumber' => $accountNumber,
                    'payment_date' => $date,
                    'payment' => $amountPaid,
                    'transaction_id' => $reference,
                    'transaction_type' => $transactionType,
                    'source' => $source,
                    'remarks' => $remarks,
                    'modifiedby' => $user
                ];
    
                $result = $SQL->InsertQuery("payment", $parameters);
    
                if ($result) {
                    $success++;
                    $row[3] = "Successfully Requested!";
                    $row[4] = true;
                    $success_data[] = $row;
                } else {
                    $fail++;
                    $row[3] = "Unsuccessfully Requested!";
                    $row[4] = false;
                    $fail_data[] = $row;
                }
            }
        }
    
        $response = [
            "success" => $success,
            "success_data" => $success_data,
            "fail" => $fail,
            "fail_data" => $fail_data
        ];
    
        return $response;
    }

    public function GetPaymentImport($client, $date){
        $date = isset($date) ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM payment
                WHERE client = '$client'
               AND payment_date = '$date'";
        $result = $SQL->SelectQuery($query);
        return $result;
    }
    

    public function CheckAccount($client, $accountnumber){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT accountnumber FROM customer_details
                WHERE client = '$client'
               AND accountnumber = '$accountnumber'";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function PostTransactions($client, $params, $user) {
        $SQL = new SQLCommands("mercedes_ois");
    
        $success = 0;
        $fail = 0;
        $success_data = [];
        $fail_data = [];
    
        for ($i = 0; $i < count($params); $i++) {
            $row = $params[$i];

            $accountNumber = $row['accountnumber'];
            $transactionId = $row['transaction_id'];
            $paymentDate = $row['payment_date'];
            $amountPaid = $row['payment'];
            $transactionType = $row['transaction_type'];
            $source = $row['source'];
            $remarks = $row['remarks'];
    
                $parameters = [
                    'client' => $client,
                    'transaction_id' => $transactionId,
                    'accountnumber' => $accountNumber,
                    'amount_paid' => $amountPaid,
                    'status' => "Paid",
                    'classification' => "normal payment",
                    'transaction_date' => $paymentDate,
                    'transaction_type' => $transactionType,
                    'source' => $source,
                    'modifiedby' => $user
                ];
    
                $result = $SQL->InsertQuery("transactions", $parameters);

                $this->UpdatePaymentPosted($client, $transactionId, $user);
    
                if ($result) {
                    $success++;
                    $row['status'] = "Successfully Posted!";
                    $row['posted'] = true;
                    $success_data[] = $row;
                } else {
                    $fail++;
                    $row['status'] = "Failed to Post!";
                    $row['posted'] = false;
                    $fail_data[] = $row;
                }
        }
    
        return [
            "result" => ($fail == 0),
            "success" => $success,
            "fail" => $fail,
            "success_data" => $success_data,
            "fail_data" => $fail_data
        ];
    }

    public function UpdatePaymentPosted($client, $transactionId, $user){
        $SQL = new SQLCommands("mercedes_ois");

        $query = "UPDATE `payment` SET 
                    `status` = 'posted',
                    modifiedby = '$user'
                    WHERE client = '$client'
                    AND transaction_id = '$transactionId'";
       
        $result = $SQL->UpdateQuery($query);
        return $result;
    }
    
}

?>
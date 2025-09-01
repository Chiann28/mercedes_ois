<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/ImportTransactionClass.php";
require_once $classFile;
$ImportTransactionClass = new ImportTransactionClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {
                case "GetPaymentImport":
                    $client = $_GET['client'] ?? "";
                    $date = $_GET['date'] ?? "";
                    $process = $ImportTransactionClass->GetPaymentImport($client, $date);
                    $response =  base64_encode(json_encode($process));
                break;
                
                default:
                    $response["error"] = "Invalid request type";
                break;
            }
            break;

            case "POST":
                $postData = json_decode(file_get_contents("php://input"), true);
                $request_type = $postData['request_type'] ?? "";
            
                switch ($request_type) {
                    case "ImportTransactions":
                        $user = $_SESSION['username'] ?? "guest";
                        $transactions = $postData['transactions'] ?? [];
                        $date = $postData['transaction_date'];
                        $client = $postData['client'];
            
                        $response = $ImportTransactionClass->ImportTransactions($client, $transactions, $date, $user);
            
                        // $response = base64_encode(json_encode($process));
                        break;

                    case "PostTransactions":
                        $user = $_SESSION['username'] ?? "guest";
                        $transactions = $postData['transactions'] ?? [];
                        $client = $postData['client'];
            
                        $response = $ImportTransactionClass->PostTransactions($client, $transactions, $user);
                    break;
            
                    default:
                        $response = ["error" => "Invalid request type"];
                        break;
                }
                break;
            

        default:
            $response["error"] = "Unsupported method";
            break;
    }

} catch (Exception $e) {
    $response["error"] = $e->getMessage();
}

echo json_encode($response);
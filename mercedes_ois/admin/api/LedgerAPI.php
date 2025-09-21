<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/LedgerClass.php";
$classFile2 = "../class/AdminExportClass.php";
require_once $classFile;
require_once $classFile2;
$LedgerClass = new LedgerClass();
$AdminExportClass = new AdminExportClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {
                case "GetAccountList":
                    $client = $_GET['client'] ?? "";
                    $accountnumber = $_GET['accountnumber'] ?? "";
                    $process = $LedgerClass->GetAccountList($client, $accountnumber);
                    $response =  base64_encode(json_encode($process));
                break;

                case "GetAccountDetails":
                    $client = $_GET['client'] ?? "";
                    $accountnumber = $_GET['accountnumber'] ?? "";
                    $process = $LedgerClass->GetAccountDetails($client, $accountnumber);
                    $response =  base64_encode(json_encode($process));
                break;
                case "GetTransactionHistory":
                    $client = $_GET['client'] ?? "";
                    $accountnumber = $_GET['accountnumber'] ?? "";
                    $process = $LedgerClass->GetTransactionHistory($client, $accountnumber);
                    $response =  base64_encode(json_encode($process));
                break;
                case "GetAdjustments":
                    $client = $_GET['client'] ?? "";
                    $accountnumber = $_GET['accountnumber'] ?? "";
                    $process = $LedgerClass->GetAdjustments($client, $accountnumber);
                    $response =  base64_encode(json_encode($process));
                break;
                case "DoGenerateBill":
                    $client = $_GET['client'] ?? "";
                    $user = $_SESSION['username'];
                    $process = $LedgerClass->DoGenerateBill($client, $user);
                    $response =  base64_encode(json_encode($process));
                break;

                case "DoPrintReceipt":
                    $transaction_reference = $_GET['transaction_reference'] ?? "";
                    $AdminExportClass = new AdminExportClass();
                    $process = $AdminExportClass->DoPrintReceipt($transaction_reference);
                    $response = base64_encode(json_encode($process));
                    exit;
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
                case "DoPostPayment":
                    $user = $_SESSION['username'];
                    $process = $LedgerClass->DoPostPayment($postData, $user);
                    $response =  base64_encode(json_encode($process));
                    break;

                default:
                    $response["error"] = "Invalid request type";
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
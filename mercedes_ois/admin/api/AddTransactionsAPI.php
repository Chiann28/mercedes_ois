<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/AddTransactionsClass.php";
require_once $classFile;
$AddTransactionsClass = new AddTransactionsClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {
                case "GetAccountList":
                    $client = $_GET['client'] ?? "";
                    $process = $AddTransactionsClass->GetAccountList($client);
                    $response =  base64_encode(json_encode($process));
                break;

                case "GetLatestTransactions":
                    $client = $_GET['client'] ?? "";
                    $accountnumber = $_GET['accountnumber'] ?? "";
                    $process = $AddTransactionsClass->GetLatestTransactions($client, $accountnumber);
                    $response =  base64_encode(json_encode($process));
                break;
                
                default:
                    $response["error"] = "Invalid request type";
                break;
            }
            break;

        case "POST":
            if (isset($_POST['request_type'])) {
                $request_type = $_POST['request_type'];
            } else {
                $postData = json_decode(file_get_contents("php://input"), true);
                $request_type = $postData['request_type'] ?? "";
            }
            
            switch ($request_type) {
                case "DoPostPayment":
                    $user = $_SESSION['username'];
                    $process = $AddTransactionsClass->DoPostPayment($postData, $user);
                    $response =  base64_encode(json_encode($process));
                    break;

                    case "UploadAttachment":
                        $user = $_SESSION['username'];
                        if (!isset($_FILES['file'])) {
                            $response = ["result" => false, "message" => "No file uploaded"];
                            break;
                        }
                
                        $client = $_POST['client'] ?? "";
                        $transaction_id = $_POST['transaction_id'] ?? "";
                        $accountnumber = $_POST['accountnumber'] ?? "";
                        $uploadDir = __DIR__ . "/../../files/payments/";
                        
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                
                        $fileTmp = $_FILES['file']['tmp_name'];
                        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); 
                        $fileName = "PAYMENT" . $accountnumber . "-" . date("Y-m-d") . "." . $ext;
                        $filePath = $uploadDir . $fileName;
                
                        if (move_uploaded_file($fileTmp, $filePath)) {
                            $save = $AddTransactionsClass->SaveAttachment($client, $accountnumber, $transaction_id, $fileName, $filePath, $_FILES['file']['type'], $_FILES['file']['size'], $user);
                            $response = ["result" => true, "message" => "File uploaded successfully", "filename" => $fileName, "save" => $save];
                        } else {
                            $response = ["result" => false, "message" => "Failed to move uploaded file", "save" => $save];
                        }
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
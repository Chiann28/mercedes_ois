<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/U_IncidentAndRequestClass.php";
require_once $classFile;
$U_IncidentAndRequestClass = new U_IncidentAndRequestClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {

                case "GetUserData":
                    // $client = $_GET['client'] ?? "";
                    // $user_id = $_SESSION['user_id'] ?? "";
                   
                    // $process = $UserDashboardClass->GetUserData($client, $user_id);
                    // $response = base64_encode(json_encode($process));
                    break;

                case "GetReportTicket":
                    $client = $_GET['client'] ?? "";
                    $accountnumber = $_GET['accountnumber'] ?? "";
                    $process = $U_IncidentAndRequestClass->GetReportTicket($client, $accountnumber);
                    $response = base64_encode(json_encode($process));
                    break;
                
                case "GetRequestTicket":
                    $client = $_GET['client'] ?? "";
                    $accountnumber = $_GET['accountnumber'] ?? "";
                    $process = $U_IncidentAndRequestClass->GetRequestTicket($client, $accountnumber);
                    $response = base64_encode(json_encode($process));
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
                case "Logout":
                    // session_unset();
                    // session_destroy();

                    // $response = [
                    //     "result" => true,
                    //     "message" => "Logged out successfully"
                    // ];
                    break;
                
                case "submitReport":
                    $client = $postData['client'];
                    $report = $postData['report'];
                    $accountnumber = $postData['accountnumber'];
                    $process = $U_IncidentAndRequestClass->submitReport($report,$client,$accountnumber);
                    $response = base64_encode(json_encode($process));
                    break;
                
                case "submitRequest":
                    $client = $postData['client'];
                    $request = $postData['request'];
                    $accountnumber = $postData['accountnumber'];
                    $process = $U_IncidentAndRequestClass->submitRequest($request,$client,$accountnumber);
                    $response = base64_encode(json_encode($process));
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
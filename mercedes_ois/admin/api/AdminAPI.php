<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/AdminClass.php";
require_once $classFile;
$AdminClass = new AdminClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {
                case "VerifySession":
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                        $response = [
                            "result" => true,
                            "username" => $_SESSION['username'],
                            "role" => $_SESSION['role']
                        ];
                    } else {
                        $response = [
                            "result" => false,
                            "message" => "Not logged in or session expired"
                        ];
                    }
                    break;

                case "DoAutoPostAnnouncement":
                    $client = $_GET['client'] ?? "";
                    $process = $AdminClass->DoAutoPostAnnouncement($client);
                    $response = base64_encode(json_encode($process));
                    break;

                case "DoAutoEmaileDue":
                    $client = $_GET['client'] ?? "";
                    $process = $AdminClass->DoAutoEmaileDue($client);
                    $response = base64_encode(json_encode($process));
                    break;
                
                case "DoGetEventDashboard":
                    $client = $_GET['client'] ?? "";
                    $process = $AdminClass->DoGetEventDashboard($client);
                    $response = base64_encode(json_encode($process));
                    break;
                
                case "GetCollectionPerMonth":
                    $client = $_GET['client'] ?? "";
                    $process = $AdminClass->GetCollectionPerMonth($client);
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
                    session_unset();
                    session_destroy();

                    $response = [
                        "result" => true,
                        "message" => "Logged out successfully"
                    ];
                    break;
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
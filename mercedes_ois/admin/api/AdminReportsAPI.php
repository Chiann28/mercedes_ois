<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/AdminReportsClass.php";
require_once $classFile;
$AdminReportsClass = new AdminReportsClass();

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

                case "resident_masterlist":
                    $client = $_GET['client'] ?? "";
                    $datefrom = $_GET['datefrom'] ?? "";
                    $dateto = $_GET['dateto'] ?? "";
                    $status = $_GET['status'] ?? "";
                    $process = $AdminReportsClass->resident_masterlist($client, $datefrom, $dateto, $status);
                    $response = base64_encode(json_encode($process));
                    break;

                case "announcement_history":
                    $client = $_GET['client'] ?? "";
                    $datefrom = $_GET['datefrom'] ?? "";
                    $dateto = $_GET['dateto'] ?? "";
                    $status = $_GET['status'] ?? "";
                    $process = $AdminReportsClass->announcement_history($client, $datefrom, $dateto, $status);
                    $response = base64_encode(json_encode($process));
                    break;
                
                case "payment_collection":
                    $client = $_GET['client'] ?? "";
                    $datefrom = $_GET['datefrom'] ?? "";
                    $dateto = $_GET['dateto'] ?? "";
                    $status = $_GET['status'] ?? "";
                    $process = $AdminReportsClass->payment_collection($client, $datefrom, $dateto, $status);
                    $response = base64_encode(json_encode($process));
                    break;

                case "events":
                    $client = $_GET['client'] ?? "";
                    $datefrom = $_GET['datefrom'] ?? "";
                    $dateto = $_GET['dateto'] ?? "";
                    $event_type = $_GET['event_type'] ?? "";
                    $process = $AdminReportsClass->events($client, $datefrom, $dateto, $event_type);
                    $response = base64_encode(json_encode($process));
                    break;
                
                case "incident":
                    $client = $_GET['client'] ?? "";
                    $datefrom = $_GET['datefrom'] ?? "";
                    $dateto = $_GET['dateto'] ?? "";
                    $type = $_GET['type'] ?? "";
                    $process = $AdminReportsClass->get_incidents($client, $datefrom, $dateto, $type);
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
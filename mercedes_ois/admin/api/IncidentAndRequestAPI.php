<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/IncidentAndRequestClass.php";
require_once $classFile;
$IncidentAndRequestClass = new IncidentAndRequestClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {
                case "GetRequestAndIncidents":
                    $client = $_GET['client'] ?? "";
                    $process = $IncidentAndRequestClass->GetRequestAndIncidents($client);
                    $response =  base64_encode(json_encode($process));
                break;

                case "GetCommentById":
                    $client = $_GET['client'] ?? "";
                    $report_id = $_GET['id'] ?? "";
                    $process = $IncidentAndRequestClass->GetCommentById($client, $report_id);
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
                case "DoPostComment":
                    $user = $_SESSION['role'];
                    $client = $postData['client'];
                    $id = $postData['id'];
                    $comment = $postData['comment'];
                    $process = $IncidentAndRequestClass->DoPostComment($client, $id, $comment, $user);
                    $response =  base64_encode(json_encode($process));
                    break;
                
                case "DoSaveChanges":
                    $user = $_SESSION['username'];
                    $process = $IncidentAndRequestClass->DoSaveChanges($postData, $user);
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
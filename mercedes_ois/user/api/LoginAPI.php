<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/LoginClass.php";
require_once $classFile;
$LoginClass = new LoginClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {
                case "getData":
                    $client = $_GET['client'] ?? "";
                    $process = $LoginClass->getData($client);
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
                case "DoLogin":
                    $client = $postData['client'] ?? "";
                    $username = $postData['username'] ?? "";
                    $password = $postData['password'] ?? "";
                    $process = $LoginClass->DoLogin($client, $username, $password);

                    //save session
                    if (!empty($process['result']) && $process['result'] === true) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['client']    = $client;
                        $_SESSION['username']  = $username;
                        $_SESSION['role']      = $process['role'] ?? "user";
                    }

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
<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/NewApplicationClass.php";
require_once $classFile;
$NewApplicationClass = new NewApplicationClass();

$response = ["data" => []];

try {
  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {

    case "GET":
      $request_type = $_GET['request_type'] ?? "";
      switch ($request_type) {
        case "GenerateAccountnumber":
          $client = $_GET['client'] ?? "";
          $process = $NewApplicationClass->GenerateAccountnumber($client);
          $response = base64_encode(json_encode($process));
          break;
        
        case "GetAccountRequest":
          $client = $_GET['client'] ?? "";
          $process = $NewApplicationClass->GetAccountRequest($client);
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
        case "CreateAccount":
          $user = $_SESSION['username'];
          $params = $postData['params'];
          $client = $postData['client'];
          $request_id = isset($postData['request_id']) ? $postData['request_id'] : null;
          $process = $NewApplicationClass->CreateAccount($user, $params, $client, $request_id );
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
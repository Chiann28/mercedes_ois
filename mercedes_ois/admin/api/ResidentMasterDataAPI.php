<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/ResidentMasterDataClass.php";
require_once $classFile;
$ResidentMasterDataClass = new ResidentMasterDataClass();

$response = ["data" => []];

try {
  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {

    case "GET":
      $request_type = $_GET['request_type'] ?? "";
      switch ($request_type) {
        case "DoCreateAccount":
 
          $client = $_GET['client'] ?? "";
          $username = $_GET['username'];
          $password = $_GET['password'];
          $role = $_GET['role'];
          $first_name = $_GET['first_name'];
          $middle_name = $_GET['middle_name'];
          $last_name = $_GET['last_name'];
          $process = $ResidentMasterDataClass->CreateAccount($client, $username, $password, $role, $first_name, $middle_name, $last_name);
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
        case "DoUpdateAccount":
          // $user = $_SESSION['username'];

          $process = $ResidentMasterDataClass->DoUpdateAccount($postData);
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
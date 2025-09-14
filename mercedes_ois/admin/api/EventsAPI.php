<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/EventsClass.php";
require_once $classFile;
$EventsClass = new EventsClass();

$response = ["data" => []];

try {
  $method = $_SERVER['REQUEST_METHOD'];

  switch ($method) {

    case "GET":
      $request_type = $_GET['request_type'] ?? "";
      switch ($request_type) {
        case "DoCountEvents":
          $client = $_GET['client'] ?? "";
          $process = $EventsClass->DoCountEvents($client);
          $response = base64_encode(json_encode($process));
          break;

        case "DoCountPastEvents":
          $client = $_GET['client'] ?? "";
          $process = $EventsClass->DoCountPastEvents($client);
          $response = base64_encode(json_encode($process));
          break;

        case "DoDeleteEvent":
          $client = $_GET['client'] ?? "";
          $event_no = $_GET['event_no'] ?? "";
          $process = $EventsClass->DoDeleteEvent($client,$event_no);
          $response = base64_encode(json_encode($process));
          break;

        case "GetEvents":
          $client = $_GET['client'] ?? "";
          $process = $EventsClass->GetEvents($client);
          $response = base64_encode(json_encode($process));
          break;

        case "GetPastEvents":
          $client = $_GET['client'] ?? "";
          $process = $EventsClass->GetPastEvents($client);
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
        case "DoPostEvent":
          $user = $_SESSION['username'];
          $params = $postData['params'];
          $client = $postData['client'];
          $process = $EventsClass->DoPostEvent($user, $client, $params);
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
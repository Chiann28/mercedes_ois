<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$classFile = "../class/AnnouncementClass.php";
require_once $classFile;
$AnnouncementClass = new AnnouncementClass();

$response = ["data" => []];

try {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {

        case "GET":
            $request_type = $_GET['request_type'] ?? "";
            switch ($request_type) {
                case "GetAnnouncements":
                    $client = $_GET['client'] ?? "";
                    $process = $AnnouncementClass->GetAnnouncements($client);
                    $response =  base64_encode(json_encode($process));
                break;

                case "GetAnnouncementAttachment":
                    $client = $_GET['client'] ?? "";
                    $announcement_no = $_GET['announcement_no'] ?? "";
                    $process = $AnnouncementClass->GetAnnouncementAttachment($client, $announcement_no);
                    $response =  base64_encode(json_encode($process));
                break;

                case "GetAnnouncementCount":
                    $client = $_GET['client'] ?? "";
                    $process = $AnnouncementClass->GetAnnouncementCount($client);
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
                case "DoAddAnnouncement":
                    $user = $_SESSION['username'];
                    $process = $AnnouncementClass->DoAddAnnouncement($postData, $user);
                    $response =  base64_encode(json_encode($process));
                    break;
                
                case "DoUpdateAnnouncement":
                    $user = $_SESSION['username'];
                    $process = $AnnouncementClass->DoUpdateAnnouncement($postData, $user);
                    $response =  base64_encode(json_encode($process));
                break; 
                
                case "UploadAttachment":
                    $user = $_SESSION['username'] ?? "system";
                    $client = $_POST['client'] ?? "";
                    $announcement_no = $_POST['announcement_no'] ?? "";
                
                    if (!isset($_FILES['files'])) {
                        $response = ["result" => false, "message" => "No files uploaded"];
                        break;
                    }
                
                    $uploadDir =__DIR__ . "/../../files/announcements/";
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                
                    $uploaded = [];
                    foreach ($_FILES['files']['tmp_name'] as $index => $tmpName) {
                        $ext = pathinfo($_FILES['files']['name'][$index], PATHINFO_EXTENSION);
                        $fileName = "AnnouncementFiles_" . $announcement_no . "_" . time() . "_$index." . $ext;
                        $filePath = $uploadDir . $fileName;
                
                        if (move_uploaded_file($tmpName, $filePath)) {
                            $save = $AnnouncementClass->SaveAttachment(
                                $client,
                                $announcement_no,
                                $fileName,
                                $filePath,
                                $_FILES['files']['type'][$index],
                                $_FILES['files']['size'][$index],
                                $user
                            );
                            $uploaded[] = ["file" => $fileName, "result" => true];
                        } else {
                            $uploaded[] = ["file" => $_FILES['files']['name'][$index], "result" => false];
                        }
                    }
                
                    $response = ["result" => true, "message" => "Files processed", "files" => $uploaded];
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
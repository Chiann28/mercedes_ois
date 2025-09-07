<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class AnnouncementClass{

    public function __construct(){
        
    }

    public function GetAnnouncements($client){
        $SQL = new SQLCommands("mercedes_ois");
        
        $query = "SELECT *
                    FROM announcements 
                WHERE client = '$client'
                ORDER BY sysentrydate DESC";
        $result = $SQL->SelectQuery($query);

        $dataByStatus = [
            "ALL" => [],
            "SCHEDULED" => [],
            "ACTIVE" => [],
            "CLOSED" => [],
            "DRAFT" => [],
            "Other" => []
        ];
        
        foreach($result as $data){
            
            $dataByStatus["ALL"][] = $data;

            switch ($data['status']) {
                case "SCHEDULED":
                    $dataByStatus["SCHEDULED"][] = $data;
                    break;
                case "ACTIVE":
                    $dataByStatus["ACTIVE"][] = $data;
                    break;
                case "CLOSED":
                    $dataByStatus["CLOSED"][] = $data;
                    break;
                case "DRAFT":
                    $dataByStatus["DRAFT"][] = $data;
                    break;
                default:
                    $dataByStatus["Other"][] = $data;
                    break;
            }
        }

        return $dataByStatus;
    }
    
    public function DoAddAnnouncement($params, $user){
        $SQL = new SQLCommands("mercedes_ois");

        $client = $params['client'];
        $announcement_no = $this->GetAnnouncementNo($client);
        $title = $params['title'] ?? NULL;
        $message = $params['message'] ?? NULL;
        $scheduled_date = date('Y-m-d', strtotime($params['scheduled_date'])) ?? date('Y-m-d');
        $status = 'PENDING';
        if($scheduled_date != "" && $scheduled_date != NULL){
            $status = "SCHEDULED";
        }
        
        
        $params = [
            "client" => $client,
            "announcement_no" => $announcement_no,
            "title" => $title,
            "status" => $status,
            "message" => $message,
            "scheduled_date" => $scheduled_date,
            "modifiedby" => $user
        ];

        $result = $SQL->InsertQuery("announcements", $params);
        
        if($result){
            return["result" => true, "message" => "Sucessfully Saved", "announcement_no" => $announcement_no];
        }

        return["result" => false, "message" => "Unsucessfully Saved", "announcement_no" => $announcement_no];
    }

    public function GetAnnouncementNo($client){
        $SQL = new SQLCommands("mercedes_ois");

        $query = "SELECT max(announcement_no) as max_no FROM announcements
                    WHERE client = '$client'";
        $result = $SQL->SelectQuery($query);
        
        if ($result[0]['max_no'] != NULL) {
            $lastNo = (int)$result[0]['max_no'];
            $nextNo = $lastNo + 1;
            $newNo = str_pad($nextNo, 3, "0", STR_PAD_LEFT);
        } else {
            $newNo = "001";
        }

        return $newNo;
        
    }

    public function GetAnnouncementCount($client){
        $SQL = new SQLCommands("mercedes_ois");

        $query = "SELECT status, COUNT(*) as total 
          FROM announcements 
          WHERE client = '$client'
          GROUP BY status";
        
        $result = $SQL->SelectQuery($query);

        $counts = [];
        foreach ($result as $row) {
            $counts[$row['status']] = (int)$row['total'];
        }

        return $counts;
    }

    public function SaveAttachment($client,$announcement_no,$fileName,$filePath,$file_type,$file_size,$user){
        $SQL = new SQLCommands("mercedes_ois");

        $params = [
            "client" => $client,
            "accountnumber" => "ANNOUNCEMENTS",
            "document_code" => $announcement_no,
            "type" => "Announcement",
            "description" => "Announcement Attachment",
            "filename" => $fileName,
            "filetype" => $file_type,
            "filesize" => $file_size,
            "filepath" => $filePath,
            "status" => 1,
            "modifiedby" => $user
        ];

        $result = $SQL->InsertQuery("requirements", $params);
        return $result;
    }

    public function GetAnnouncementAttachment($client, $announcement_no){
        $SQL = new SQLCommands("mercedes_ois");
        
        $query = "SELECT `filename`
                    FROM requirements
                WHERE client = '$client'
                AND document_code = '$announcement_no'
                AND accountnumber = 'ANNOUNCEMENTS'
                ORDER BY sysentrydate ASC";
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function DoUpdateAnnouncement($params, $user){
        $SQL = new SQLCommands("mercedes_ois");

        $client = $params['client'];
        $title = $params['title'] ?? NULL;
        $message = $params['message'] ?? NULL;
        $scheduled_date = date('Y-m-d', strtotime($params['scheduled_date'])) ?? date('Y-m-d');
        $status = $params['status'] ?? NULL;
        $announcement_no = $params['announcement_no'] ?? NULL;

        $query = "UPDATE announcements 
                    SET title = '$title',
                    `message` = '$message',
                    `status` = '$status',
                    scheduled_date = '$scheduled_date',
                    modifiedby = '$user'
                    WHERE client = '$client'
                    AND announcement_no = '$announcement_no'";
        
        $result = $SQL->UpdateQuery($query);
        
        if($result){
            return["result" => true, "message" => "Sucessfully Posted", "announcement_no" => $announcement_no];
        }

        return["result" => false, "message" => "Unsucessfully Posted", "announcement_no" => $announcement_no];
    }
    
}

?>
<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class IncidentAndRequestClass{

    public function __construct(){
        
    }

    public function GetRequestAndIncidents($client){
        $SQL = new SQLCommands("mercedes_ois");
        
        $query = "SELECT *, 
                    DATE(sysentrydate) as sysentrydate,
                    DATE(modifieddate) as modifieddate FROM requests_and_incidents
                WHERE client = '$client' ORDER BY sysentrydate DESC";
        $result = $SQL->SelectQuery($query);

        $dataByStatus = [
            "All" => [],
            "New" => [],
            "In_Progress" => [],
            "Resolved" => [],
            "Closed" => [],
            "Other" => []
        ];
        
        foreach($result as $data){
            
            $dataByStatus["All"][] = $data;

            switch ($data['status']) {
                case "New":
                    $dataByStatus["New"][] = $data;
                    break;
                case "In Progress":
                    $dataByStatus["In_Progress"][] = $data;
                    break;
                case "Resolved":
                    $dataByStatus["Resolved"][] = $data;
                    break;
                case "Closed":
                    $dataByStatus["Closed"][] = $data;
                    break;
                default:
                    $dataByStatus["Other"][] = $data;
                    break;
            }
        }

        return $dataByStatus;
    }
    
    public function DoPostComment($client, $id, $comment, $user){
        $SQL = new SQLCommands("mercedes_ois");

        $params = [
            "client" => $client,
            "report_id" => $id,
            "description" => $comment,
            "modifiedby" => $user
        ];

        $result = $SQL->InsertQuery("comments", $params);
        return $result;
    }

    public function GetCommentById($client, $report_id){
        $SQL = new SQLCommands("mercedes_ois");

        $query = "SELECT *,
                    DATE(sysentrydate) AS `comment_date`, 
                    DATE_FORMAT(sysentrydate, '%h:%i %p') AS `comment_time` 
                    FROM comments WHERE client = '$client'
                    AND report_id = '$report_id' ";
        
        $result = $SQL->SelectQuery($query);
        return $result;
    }

    public function DoSaveChanges($params, $user){
        $client = $params['client'] ?? '';
        $id = $params['id'] ?? '';
        $description = $params['description'] ?? '';
        $priority = $params['priority'] ?? '';
        $status = $params['status'] ?? '';
        $resolved_date = date('Y-m-d', strtotime($params['resolved_date'])) ?? '';
        $user = $params['user'] ?? "";

        $SQL = new SQLCommands("mercedes_ois");

        $query = "UPDATE `requests_and_incidents` SET 
                    `description` = '$description',
                    priority = '$priority',
                    `status` = '$status',
                    resolved_date = '$resolved_date'
                    WHERE client = '$client'
                    AND id = '$id'";
    //    echo $query;
        $result = $SQL->UpdateQuery($query);
        return $result;
    }
    
}

?>
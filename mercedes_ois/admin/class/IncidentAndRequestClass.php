<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class IncidentAndRequestClass{

    public function __construct(){
        
    }

    public function GetRequestAndIncidents($client){
        $SQL = new SQLCommands("mercedes_ois");
        
        $query = "SELECT * FROM requests_and_incidents
                WHERE client = '$client'";
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
    
}

?>
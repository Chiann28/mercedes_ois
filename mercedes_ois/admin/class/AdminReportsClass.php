<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class AdminReportsClass{

    public function __construct(){
        
    }


    public function resident_masterlist($client, $datefrom, $dateto, $status) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        if($status == ""){
            $status_filter = "";
        }else{
            $status_filter = "AND status = '$status'";
        }


        $query = "SELECT * FROM customer_details
                    WHERE registration_date BETWEEN '$datefrom' AND '$dateto'
                    $status_filter";
        $result = $SQL->SelectQuery($query);
       
        return $result;
    }

    public function announcement_history($client, $datefrom, $dateto, $status) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        if($status == ""){
            $status_filter = "";
        }else{
            $status_filter = "AND status = '$status'";
        }

        $query = "SELECT * FROM announcements
                    WHERE DATE(sysentrydate) BETWEEN '$datefrom' AND '$dateto'
                    $status_filter";
        $result = $SQL->SelectQuery($query);

        return $result;
    }

    public function payment_collection($client, $datefrom, $dateto, $status) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        if($status == ""){
            $status_filter = "";
        }else{
            $status_filter = "AND t.status = '$status'";
        }

        $query = "SELECT *, c.fullname, t.status as payment_status FROM transactions t
                    LEFT JOIN customer_details c
                    ON c.client = t.client 
                    AND c.accountnumber = t.accountnumber
                    WHERE t.transaction_date BETWEEN '$datefrom' AND '$dateto'
                    $status_filter";
        $result = $SQL->SelectQuery($query);

        return $result;
    }

    public function events($client, $datefrom, $dateto, $event_type) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        if($event_type == ""){
            $event_filter = "";
        }else{
            $event_filter = "AND event_type = '$event_type'";
        }

        $query = "SELECT * FROM events
                    WHERE DATE(sysentrydate) BETWEEN '$datefrom' AND '$dateto'
                    $event_filter";
        $result = $SQL->SelectQuery($query);

        return $result;
    }


    public function get_incidents($client, $datefrom, $dateto, $type) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        if($type == ""){
            $filter = "";
        }else{
            $filter = "AND type = '$type'";
        }

        $query = "SELECT * FROM requests_and_incidents
                    WHERE DATE(sysentrydate) BETWEEN '$datefrom' AND '$dateto'
                    $filter";
        $result = $SQL->SelectQuery($query);

        return $result;
    }
    
}

?>
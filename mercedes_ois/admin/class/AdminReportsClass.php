<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class AdminReportsClass{

    public function __construct(){
        
    }


    public function resident_masterlist($client, $datefrom, $dateto) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $query = "SELECT * FROM customer_details
                    WHERE registration_date BETWEEN '$datefrom' AND '$dateto'";
        $result = $SQL->SelectQuery($query);

        return $result;
    }

    public function announcement_history($client, $datefrom, $dateto) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $query = "SELECT * FROM announcements
                    WHERE DATE(sysentrydate) BETWEEN '$datefrom' AND '$dateto'";
        $result = $SQL->SelectQuery($query);

        return $result;
    }

    public function payment_collection($client, $datefrom, $dateto) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $query = "SELECT *, c.fullname, t.status as payment_status FROM transactions t
                    LEFT JOIN customer_details c
                    ON c.client = t.client 
                    AND c.accountnumber = t.accountnumber
                    WHERE t.transaction_date BETWEEN '$datefrom' AND '$dateto'";
        $result = $SQL->SelectQuery($query);

        return $result;
    }

    public function events($client, $datefrom, $dateto) {
        $SQL = new SQLCommands("mercedes_ois");
        $datefrom = date('Y-m-d', strtotime($datefrom));
        $dateto = date('Y-m-d', strtotime($dateto));

        $query = "SELECT * FROM events
                    WHERE DATE(sysentrydate) BETWEEN '$datefrom' AND '$dateto'";
        $result = $SQL->SelectQuery($query);

        return $result;
    }
    
}

?>
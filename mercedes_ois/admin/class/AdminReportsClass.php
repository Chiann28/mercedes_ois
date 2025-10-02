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
    
}

?>
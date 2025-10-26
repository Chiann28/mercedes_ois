<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class U_IncidentAndRequestClass
{

  public function __construct()
  {

  }

  public function DoLogin($client, $username, $password)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "SELECT * FROM user_accounts
                WHERE client = '$client'
                AND username = '$username'
                AND `password` = '$password'
                LIMIT 1";
    $result = $SQL->SelectQuery($query);


    if (empty($result) || count($result) == 0) {
      return [
        "result" => false,
        "message" => "Invalid Username or Password",
        "username" => $username

      ];
    }

    $user = $result[0];

    if (isset($user['role']) && strtolower($user['role']) === "admin") {
      return [
        "result" => true,
        "message" => "Login successful",
        "username" => $username,
        "role" => "admin",
        "user_id" => $user["user_id"] ?? ""
      ];
    } else {
      return [
        "result" => true,
        "message" => "Login successful",
        "username" => $username,
        "role" => $user['role'] ?? "user",
        "user_id" => $user["user_id"] ?? ""
      ];
    }

  }

  public function getAccountName($accountnumber)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "SELECT fullname FROM customer_details WHERE client = 'mercedes' AND accountnumber = '$accountnumber'
      ";
    $result = $SQL->SelectQuery($query);
    return $result;
  }

  public function submitReport($report, $client, $accountnumber)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $accountResult = $this->getAccountName($accountnumber);
    $accountname = isset($accountResult[0]['fullname']) ? strtoupper($accountResult[0]['fullname']) : 'Unknown';
    
    $parameters = [
      'client' => $client,
      'type' => 'incident',
      'requested_by' => $accountname,
      'accountnumber' => $accountnumber,
      'category' => $report['category'],
      'title' => $report['title'],
      'description' => $report['description'],
      'priority' => 'Medium',
      'status' => 'New',
      'location' => $report['location']
    ];

    $result = $SQL->InsertQuery("requests_and_incidents", $parameters);

    if (!$result) {
      return ["result" => false, "message" => "Failed",];
    } else {
      return ["result" => true, "message" => "Success",];
    }

  }

  public function GetReportTicket($client,$accountnumber)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "SELECT * FROM requests_and_incidents WHERE client = 'mercedes' AND accountnumber = '$accountnumber' AND type = 'incident' ORDER BY sysentrydate DESC
      ";
    $result = $SQL->SelectQuery($query);
    return $result;
  }

  public function loadComments($client,$report_id)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "SELECT *, 
                    DATE(sysentrydate) AS `comment_date`, 
                    DATE_FORMAT(sysentrydate, '%h:%i %p') AS `comment_time`
              FROM comments WHERE client = '$client' 
              AND report_id = '$report_id' ORDER BY sysentrydate
      ";
    $result = $SQL->SelectQuery($query);
    return $result;
  }

  public function submitRequest($request, $client, $accountnumber)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $accountResult = $this->getAccountName($accountnumber);
    $accountname = isset($accountResult[0]['fullname']) ? strtoupper($accountResult[0]['fullname']) : 'Unknown';
    $location = isset($request['location']) ? $request['location'] : '' ;
    
    $parameters = [
      'client' => $client,
      'type' => 'request',
      'requested_by' => $accountname,
      'accountnumber' => $accountnumber,
      'category' => $request['category'],
      'title' => $request['title'],
      'description' => $request['description'],
      'priority' => 'Medium',
      'status' => 'New',
      'location' => $location
    ];

    $result = $SQL->InsertQuery("requests_and_incidents", $parameters);

    if (!$result) {
      return ["result" => false, "message" => "Failed",];
    } else {
      return ["result" => true, "message" => "Success",];
    }

  }

  public function GetRequestTicket($client,$accountnumber)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "SELECT * FROM requests_and_incidents WHERE client = 'mercedes' AND accountnumber = '$accountnumber' AND type = 'request' ORDER BY sysentrydate DESC
      ";
    $result = $SQL->SelectQuery($query);
    return $result;
  }

  public function DoPostComment($client, $params) {
    $SQL = new SQLCommands("mercedes_ois");

    $parameters = [
      'client' => $client,
      'report_id' => $params['report_id'],
      'description' => $params['comment'],
      'commentor_name' => $params['fullname'],
      'commentor_id' => $params['accountnumber'],
      'modifiedby' => $params['fullname']
    ];

    $result = $SQL->InsertQuery("comments", $parameters);

    if (!$result) {
      return ["result" => false, "message" => "Failed",];
    } else {
      return ["result" => true, "message" => "Success",];
    }
  }



}

?>
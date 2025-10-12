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
    $query = "SELECT * FROM requests_and_incidents WHERE client = 'mercedes' AND accountnumber = '$accountnumber' AND type = 'incident'
      ";
    $result = $SQL->SelectQuery($query);
    return $result;
  }



}

?>
<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class ResidentMasterDataClass
{

  public function __construct()
  {

  }

  public function GenerateAccountnumber()
  {
    $SQL = new SQLCommands("mercedes_ois");

    do {
      $accountNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

      $query = "SELECT accountnumber FROM user_accounts WHERE accountnumber = '$accountNumber' LIMIT 1";

      $exists = $SQL->SelectQuery($query);

    } while (!empty($exists));

    return $accountNumber;
  }


  public function CreateAccount($client, $username, $password, $role, $first_name, $middle_name, $last_name)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $role = strtolower($role);

    if ($role === 'admin') {
      $parameters = [
        'client' => $client,
        'username' => $username,
        'password' => $password,
        'role' => $role,
        'firstname' => $first_name,
        'middlename' => $middle_name,
        'lastname' => $last_name
      ];
      $result = $SQL->InsertQuery('user_accounts', $parameters);
      if ($result) {
        return [
          "result" => true,
          "message" => "Account Created",
        ];
      } else {
        return [
          "result" => false,
          "message" => "Account Creation Unsuccessful",
        ];
      }

    } elseif ($role === 'user') {
      $accountnumber = $this->GenerateAccountnumber();
      $parameters = [
        'client' => $client,
        'accountnumber' => $accountnumber,
        'username' => $username,
        'password' => $password,
        'role' => $role,
        'firstname' => $first_name,
        'lastname' => $last_name
      ];

      $result = $SQL->InsertQuery('user_accounts', $parameters);

      $parameters = [
        'client' => $client,
        'accountnumber' => $accountnumber,
        'firstname' => strtoupper($first_name),
        'middlename' => strtoupper($middle_name),
        'lastname' => strtoupper($last_name)
      ];

      $result = $SQL->InsertQuery('customer_details', $parameters);

      if ($result) {
        return ["result" => true, "message" => "Account Created", "accountnumber" => $accountnumber];
      } else {
        return ["result" => false, "message" => "Account Creation Unsuccessful",];
      }

    } else {
      return [
        "result" => false,
        "message" => "Invalid Role.",
      ];
    }






  }
  public function InsertAccountDetails($username, $password, $role)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "INSERT INTO ";
    $result = $SQL->InsertQuery('customer_details', $query);
    return $result;
  }

}

?>
<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class NewApplicationClass
{

  public function __construct()
  {

  }

  public function CreateAccount($client, $username, $password, $role, $first_name, $last_name)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $parameters = [
      'client' => $client,
      'username' => $username,
      'password' => $password,
      'role' => $role,
      'firstname' => $first_name,
      'lastname' => $last_name
    ];
    $result = $SQL->InsertQuery('user_accounts',$parameters);
    return $result;
  }
  public function InsertAccountDetails($username, $password, $role)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "INSERT INTO ";
    $result = $SQL->SelectQuery($query);
    return $result;
  }

}

?>
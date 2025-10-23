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

  public function DoUpdateFullName($client,$accountnumber) {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "UPDATE customer_details 
    SET fullname = CONCAT(firstname, ' ' , middlename , ' ', lastname) 
    WHERE client = '$client' 
    AND accountnumber = '$accountnumber'
    ";
    $result = $SQL->UpdateQuery($query);
    return $result;
  }

  public function DoTagProperty ($client,$code,$accountnumber){
     $SQL = new SQLCommands("mercedes_ois");
     $query = "UPDATE properties SET accountnumber = '$accountnumber' ,property_status = 'ACTIVE'
              WHERE client = '$client'
              AND property_code = '$code'
              ";
     $result = $SQL->UpdateQuery($query);
    return $result;
  }

  public function CheckIfActiveProperty($client,$code){
    $SQL = new SQLCommands("mercedes_ois");
    $query = "SELECT * FROM properties WHERE client = '$client' 
    AND property_code = '$code'
    AND property_status = 'ACTIVE'
    ";
    $result = $SQL->SelectQuery($query);
    return $result; 
  }

  public function DoUpdateAccount($params)
  {
    $SQL = new SQLCommands("mercedes_ois");
    // print_r($params); die();
    $firstname = $params['firstname'];
    $middlename = $params['middlename'];
    $lastname = $params['lastname'];
    $client = $params['client'];
    $accountnumber = $params['accountnumber'];
    $email = $params['email'];
    $contact_number = $params['contact_number'];
    $status = $params['status'];
    $property_code = $params['property_code'];

    $is_occupied = $this->CheckIfActiveProperty($client,$property_code);
    if($is_occupied){
      $response = ["result" => false, "message" => "Property Code '$property_code' is currently active.",];
      return $response;
    }

    $query = "UPDATE customer_details
                SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', contact_number = '$contact_number', email = '$email', status = '$status'
              WHERE client = '$client'
                    AND accountnumber = '$accountnumber';
                    ";

    $result = $SQL->UpdateQuery($query);
    if(!$result){
      $response = ["result" => false, "message" => "Something Went Wrong. Account Update Failed.",];
    }else{
      $this->DoUpdateFullName($client,$accountnumber);
      $this->DoTagProperty($client,$property_code,$accountnumber);
      $response = ["result" => true, "message" => "Account : $accountnumber Updated Successfuly", "accountnumber" => $accountnumber];
    }
    return $response;
    ;
  }


}

?>
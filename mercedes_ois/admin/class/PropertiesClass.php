<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class PropertiesClass
{

  public function __construct()
  {

  }

  function validateRequiredFields($params, $required)
  {
    $values = [];
    foreach ($required as $field) {
      if (!isset($params[$field]) || $params[$field] === null || $params[$field] === '') {
        return false;
      }
      $values[$field] = $params[$field];
    }
    return $values;
  }


  public function GenerateAccountnumber($client)
  {
    $SQL = new SQLCommands("mercedes_ois");

    do {
      $accountNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

      $query = "SELECT accountnumber FROM user_accounts WHERE client = '$client' AND accountnumber = '$accountNumber' LIMIT 1";

      $exists = $SQL->SelectQuery($query);

    } while (!empty($exists));

    return $accountNumber;
  }

  public function CreateAccount($user, $params, $client, $request_id)
  {
    $SQL = new SQLCommands("mercedes_ois");


    // Validate Required fields (EJSB)
    $requiredFields = [
      "firstname",
      "lastname",
      "email",
      "mobile_no",
      "accountnumber",
      "username",
      "password",
      "unittype",
      "lot_no",
      "house_no",
      // "ref_fullname", "ref_rel"
    ];

    $validated = $this->validateRequiredFields($params, $requiredFields);

    if ($validated === false) {
      return [
        "result" => false,
        "message" => "Missing required fields",
      ];
    } else {
      //declare once validated
      $firstname = $validated["firstname"];
      $lastname = $validated["lastname"];
      $email = $validated["email"];
      $mobile_no = $validated["mobile_no"];
      $accountnumber = $validated["accountnumber"];
      $username = $validated["username"];
      $password = $validated["password"];
      $unit_type = $validated["unittype"];
      $lot_no = $validated["lot_no"];
      $house_no = $validated["house_no"];

    }

    //nullify unrequired fields if no input
    $tel_no = isset($params["tel_no"]) ? $params["tel_no"] : null;
    $ref_fullname = isset($params["ref_fullname"]) ? $params["ref_fullname"] : null;
    $ref_rel = isset($params["ref_rel"]) ? $params["ref_rel"] : null;



    // create account for the user
    $parameters = [
      'client' => $client,
      'accountnumber' => $accountnumber,
      'username' => $username,
      'password' => $password,
      'firstname' => $firstname,
      'lastname' => $lastname,
      'role' => 'user'
    ];

    $result = $SQL->InsertQuery('user_accounts', $parameters);
    if ($result) {
      //pass the details in customer_details
      $parameters = [
        'client' => $client,
        'accountnumber' => $accountnumber,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'type' => $unit_type,
        'lot_number' => $lot_no,
        'house_no' => $house_no,
        'contact_number' => $mobile_no,
        'email' => $email,
        'status' => 'ACTIVE',
        'registration_date' => date('Y-m-d'),
        'modifiedby' => $user
      ];
      $result = $SQL->InsertQuery('customer_details', $parameters);
      if ($result) {
        //update request if true
        if (!empty($request_id)) {
          $query = "UPDATE account_request 
              SET req_status = 'APPROVED' 
              WHERE client = '$client' 
                AND request_id = '$request_id'";
          $result = $SQL->UpdateQuery($query);
        }
        return ["result" => true, "message" => "Account Created",];
      } else {
        return ["result" => false, "message" => "Failed Account Creation",];
      }

    } else {
      return ["result" => false, "message" => "Account Creation Unsuccessful",];
    }

  }

  public function CreateProperty($user, $params, $client) {
    $SQL = new SQLCommands("mercedes_ois");
    $parameters = [
      'client' => $client,
      'property_code' => $params['property_code'],
      'property_type' => $params['property_type'],
      'property_name' => $params['property_name'],
      'block_no' => $params['block_no'],
      'lot_no' => $params['lot_no'],
      'modifiedby' => $user
    ];

    $result = $SQL->InsertQuery('properties', $parameters);
    if ($result) {
        $parameters2 = [
          'client' => $client,
          'property_code' => $params['property_code'],
          'property_name' => $params['property_name'],
          'property_type' => $params['property_type'],
          'location' => $params['location'],
          'price' => $params['price'],
          'modifiedby' => $user
        ];
        $result2 = $SQL->InsertQuery('ref_properties', $parameters2);
        if ($result2) {
        return ["result" => true, "message" => "Success",];
        } else {
        return ["result" => false, "message" => "Failed",];
        }
        
      } else {
        return ["result" => false, "message" => "Failed",];
      }
  }

  public function GetAccountRequest($client)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $query = "SELECT *, CONCAT(firstname,' ',lastname) AS `fullname` FROM account_request 
                WHERE client = '$client' 
                AND req_status = 'PENDING' 
                ORDER BY sysentrydate DESC;
    ";

    $result = $SQL->SelectQuery($query);

    return $result;
  }

}

?>
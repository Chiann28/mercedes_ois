<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";
require_once __DIR__. "/../../framework/PHPMailer-master/src/PHPMailer.php";
require_once __DIR__. "/../../framework/PHPMailer-master/src/SMTP.php";
require_once __DIR__. "/../../framework/PHPMailer-master/src/Exception.php";

class NewApplicationClass
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

        $sent = $this->SendRegistrationEmail($email, $firstname, $username, $password);

        return ["result" => true, "message" => "Account Created", "sent" => $sent];
      } else {
        return ["result" => false, "message" => "Failed Account Creation",];
      }

    } else {
      return ["result" => false, "message" => "Account Creation Unsuccessful",];
    }

  }

  private function SendRegistrationEmail($to, $firstname, $username, $password)
{
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dgrtsaganmeow@gmail.com';
        $mail->Password   = 'xzab bfpp sgcg ldyx'; // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('dgrtsaganmeow@gmail.com', 'Mercedes Billing');
        $mail->addAddress($to);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Welcome to Mercedes - Your Account Details";
        $mail->Body = "
            Dear <b>$firstname</b>,<br><br>
            Your account has been successfully created.<br><br>
            <b>Login Credentials:</b><br>
            Username: <b>$username</b><br>
            Password: <b>$password</b><br><br>
            Please keep this information secure.<br><br>
            Thank you,<br>
            Mercedes Billing Team
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Failed to send registration email to $to: " . $mail->ErrorInfo);
        return false;
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
<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class LoginClass
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

    public function GenerateRequestId($client)
    {
        $SQL = new SQLCommands("mercedes_ois");

        do {
            $reqid = str_pad(mt_rand(0, 99999999), 6, '0', STR_PAD_LEFT);

            $query = "SELECT request_id FROM account_request WHERE client = '$client' AND request_id = '$reqid' LIMIT 1";

            $exists = $SQL->SelectQuery($query);

        } while (!empty($exists));

        return $reqid;
    }

    public function DoAccountRequest($params, $client)
    {
        $SQL = new SQLCommands("mercedes_ois");
        $request_id = $this->GenerateRequestId($client);
        $parameters = [
            'client' => $client,
            'firstname' => $params['firstname'],
            'lastname' => $params['lastname'],
            'username' => $params['username'],
            'email' => $params['email'],
            'mobile_no' => $params['mobile_no'],
            // 'unittype' => $params['unittype'],
            // 'lot_no' => $params['lot_no'],
            // 'house_no' => $params['house_no'],
            'ref_fullname' => $params['ref_name'],
            'ref_mobile_no' => $params['ref_contact'],
            'request_id' => $request_id,
            'req_status' => 'PENDING',
            'request_date' => date('Y-m-d')

        ];
        $result = $SQL->InsertQuery('account_request', $parameters);
        if (!$result) {
            return ["result" => false, "message" => "Failed",];
        } else {
            return ["result" => true, "message" => "Success",];
        }

    }

    public function PWResetCheckIfValid($client, $input)
    {
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT ua.*,cd.email 
                    FROM user_accounts ua 
                    LEFT JOIN customer_details cd ON cd.accountnumber = ua.accountnumber
                    WHERE ua.client = '$client' 
                    AND (ua.username = '$input' OR cd.email = '$input')
                    ";
        $result = $SQL->SelectQuery($query);
        if (!empty($result)) {
            return [
                "response" => true,
                "data" => $result[0]
            ];
        } else {
            return [
                "response" => false,
                "message" => "No matching account or email found."
            ];
        }
    }

}

?>
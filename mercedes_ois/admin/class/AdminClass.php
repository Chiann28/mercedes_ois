<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";
require_once __DIR__. "/../../framework/PHPMailer-master/src/PHPMailer.php";
require_once __DIR__. "/../../framework/PHPMailer-master/src/SMTP.php";
require_once __DIR__. "/../../framework/PHPMailer-master/src/Exception.php";

class AdminClass{

    public function __construct(){
        
    }

    public function DoLogin($client, $username, $password){
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT * FROM user_accounts
                WHERE client = '$client'
                AND username = '$username'
                AND `password` = '$password'
                LIMIT 1";
        $result = $SQL->SelectQuery($query);

        
        
        if (empty($result) || count($result) == 0) {
            return [
                "result"   => false,
                "message"  => "Invalid Username or Password",
                "username" => $username
            ];
        }

        $user = $result[0];

        if (isset($user['role']) && strtolower($user['role']) === "admin") {
            return [
                "result"   => true,
                "message"  => "Login successful",
                "username" => $username,
                "role"     => "admin"
            ];
        } else {
            return [
                "result"   => true,
                "message"  => "Login successful",
                "username" => $username,
                "role"     => $user['role'] ?? "user"
            ];
        }

    }

    //auto posting of announcements
    public function DoAutoPostAnnouncement($client){
        $SQL = new SQLCommands("mercedes_ois");
        $date = date('Y-m-d');

        $query = "SELECT announcement_no FROM announcements
                    WHERE client = '$client'
                    AND scheduled_date <= '$date'
                    AND status = 'SCHEDULED'";
        $result = $SQL->SelectQuery($query);

        if ($result && count($result) > 0) {
            foreach ($result as $row) {
                $announcement_no = $row['announcement_no'];
    
                $update = "UPDATE `announcements` 
                            SET `status` = 'POSTED'
                            WHERE client = '$client'
                            AND announcement_no = '$announcement_no'";
                $SQL->UpdateQuery($update);
            }
            return true;
        }
    
        return false;
    }

    public function DoGetEventDashboard($client) {
        $SQL = new SQLCommands("mercedes_ois");
        $date = date('Y-m-d');

        $query = "SELECT *, date(start_date) as `date_start`
         FROM events WHERE date(start_date) >= '$date' ORDER BY start_date LIMIT 3";
        $result = $SQL->SelectQuery($query);

        return $result;
    }

    public function DoAutoEmaileDue() {
        $SQL = new SQLCommands("mercedes_ois");
    
        $query = "SELECT 
                    b.transaction_date,
                    c.accountnumber,
                    c.email,
                    DATE_ADD(b.transaction_date, INTERVAL 30 DAY) AS due_date,
                    e.sent_date
                FROM balance_sheet b
                INNER JOIN (
                    SELECT accountnumber, MAX(transaction_date) AS latest_date
                    FROM balance_sheet
                    WHERE transaction_type = 'Bill'
                    GROUP BY accountnumber
                ) latest
                    ON b.accountnumber = latest.accountnumber
                AND b.transaction_date = latest.latest_date
                INNER JOIN customer_details c
                    ON c.client = b.client
                AND c.accountnumber = b.accountnumber
                LEFT JOIN email_reminders e
                    ON e.accountnumber = c.accountnumber
                AND e.due_date = DATE_ADD(b.transaction_date, INTERVAL 30 DAY)
                WHERE DATE_ADD(b.transaction_date, INTERVAL 30 DAY) <= CURDATE() + INTERVAL 5 DAY
                AND (e.sent_date IS NULL OR e.sent_date < CURDATE())
                ";
                    
        $result = $SQL->SelectQuery($query);
        $sent = [];
    
        if ($result && count($result) > 0) {
            foreach ($result as $row) {
                if (!empty($row['email'])) {
                    $ok = $this->SendDueEmail(
                        $row['email'],
                        $row['accountnumber'],
                        $row['due_date']
                    );

                    $this->insertEmailReminder($row['email'],  $row['accountnumber'],$row['due_date']);

                    $sent[] = [
                        'email'  => $row['email'],
                        'status' => $ok ? 'sent' : 'failed',
                        'due'    => $row['due_date']
                    ];
                }
            }
        }
    
        return $sent;
    }

    public function insertEmailReminder($email, $accountnumber, $due_date){
        $SQL = new SQLCommands("mercedes_ois");
        $date_sent = date('Y-m-d');
        $parameters = [
            "accountnumber" => $accountnumber,
            "due_date" => $due_date,
            "sent_date" => $date_sent
        ];

        $result = $SQL->InsertQuery("email_reminders", $parameters);
        return $result;
    }
    
    


    private function SendDueEmail($to, $account, $dueDate) {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dgrtsaganmeow@gmail.com';
            $mail->Password   = 'xzab bfpp sgcg ldyx';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
    
            // Recipients
            $mail->setFrom('dgrtsaganmeow@gmail.com', 'Mercedes Billing');
            $mail->addAddress($to);
    
            // Email Content
            $mail->isHTML(true);
            $mail->Subject = "Payment Reminder - Account $account";
            $mail->Body    = "Dear Customer,<br><br>
                              Your bill is due on <b>$dueDate</b>.<br>
                              Please make the payment to avoid late fees.<br><br>
                              Thank you,<br>Mercedes Finance Team";
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Could not send email to $to. Error: {$mail->ErrorInfo}<br>";
        }
    }
    
}

?>
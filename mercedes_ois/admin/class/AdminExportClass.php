<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";

class AdminExportClass{

    public function __construct(){
        
    }

    public function DoPrintReceipt($transaction_reference) {
        $SQL = new SQLCommands("mercedes_ois");
        $query = "SELECT t.*, c.*, a.* FROM transactions t
                    LEFT JOIN customer_details c
                    ON c.client = t.client
                    AND c.accountnumber = t.accountnumber 
                    LEFT JOIN adjustments a
                    ON a.client = t.client
                    AND a.reference = '$transaction_reference'
                    WHERE t.transaction_id = '$transaction_reference'";
        $result = $SQL->SelectQuery($query);
        $data = $result[0];
        $transaction_reference = $data['transaction_id'] ?? NULL;
        $amount_paid = $data['amount_paid'] ?? NULL;
        $adjustment = $data['amount'] ?? NULL;
        $transaction_date = $data['transaction_date'];

        $html = "
        <html>
        <head>
          <style>
            body { font-family: monospace; font-size: 12px; }
            .receipt { width: 250px; margin: auto; }
            .center { text-align: center; }
            .line { border-top: 1px dashed #000; margin: 5px 0; }
          </style>
        </head>
        <body onload='window.print()'>
          <div class='receipt'>
            <div class='center'>
              <h4>BILLING INVOICE</h4>
              <p>123 Main St.<br>Tel: 0912-345-6789</p>
            </div>
            <div class='line'></div>
            <p>Transaction #: {$transaction_reference}</p>
            <p>Date: {$transaction_date}</p>
            <div class='line'></div>
            <p>Payment: ₱{$amount_paid}</p>
            <div class='line'></div>
            <div class='center'>Thank you!</div>
          </div>
        </body>
        </html>
        ";
    
        return $html;
    }
    
    
}

?>
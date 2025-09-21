<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";
require_once __DIR__ . "/../../framework/TCPDF-main/tcpdf.php";
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
        
        $accountnumber = $data['accountnumber'] ?? NULL;
        $transaction_reference = $data['transaction_id'] ?? NULL;
        $amount_paid = isset($data['amount_paid']) ? (float)$data['amount_paid'] : 0;
        $adjustment  = isset($data['amount']) ? $data['amount'] : 0;
        $transaction_date = $data['transaction_date'] ?? date("Y-m-d");
        $due_date = date("Y-m-d", strtotime($transaction_date . " + 30 days"));
        
        

        $bill_query = "
        SELECT debit, transaction_date
        FROM balance_sheet
        WHERE transaction_type = 'Bill'
        AND accountnumber = '$accountnumber'
        AND transaction_date BETWEEN DATE_FORMAT('$transaction_date', '%Y-%m-01') 
                                AND LAST_DAY('$transaction_date');
        ";
        $result_bill = $SQL->SelectQuery($bill_query);
        $bill_price = $result_bill[0]['debit'];

        $balance_query = "SELECT balance FROM balance_sheet 
                            WHERE accountnumber = '$accountnumber'
                            ORDER BY transaction_date_time DESC LIMIT 1";
        $result_balance = $SQL->SelectQuery($balance_query);
        $latest_balance = $result_balance[0]['balance'];
        $html = "
                <style>
                body { font-family: monospace; font-size: 9pt; margin:0; padding:0; }
                .receipt { width: 100%; }
                .center { text-align: center; }
                .line { border-top: 1px dashed #000; margin: 3px 0; }
                table { width: 100%; border-collapse: collapse; }
                td { padding: 2px 0; }
                </style>

                <div class='receipt'>
                    <!-- Header -->
                    <div class='center'>
                        <img src=\"logo_mercedes.png\" alt=\"Company Logo\" style=\"width:40px; height:auto;\" /><br>
                        <strong>BILLING INVOICE</strong><br>
                        <span style='font-size:8pt;'>Soro Soro Ilaya, Batangas City<br>Tel: 0912-345-6789</span>
                    </div>

                    <div class='line'></div>

                    <!-- Transaction Info -->
                    <p><strong>Transaction #:</strong> {$transaction_reference}</p>
                    <p><strong>Date:</strong> {$transaction_date}</p>

                    <div class='line'></div>

                    <!-- Items -->
                    <table>
                        <tr>
                            <td><strong>Description</strong></td>
                            <td style='text-align:right;'><strong>Price</strong></td>
                        </tr>
                        <tr>
                            <td>Bill For " . date("F Y", strtotime($transaction_date)) . "</td>
                            <td style='text-align:right;'>" . number_format($bill_price, 2) . "</td>
                        </tr>
                    </table>

                    <div class='line'></div>

                    <!-- Summary -->
                    <table>
                        <tr>
                            <td><b>Amount Due:</b></td>
                            <td style='text-align:right;'><b>" . number_format($amount_paid, 2) . "</b></td>
                        </tr>
                        <tr>
                            <td>Due Date:</td>
                            <td style='text-align:right;'>{$due_date}</td>
                        </tr>
                        <tr>
                            <td>Payment:</td>
                            <td style='text-align:right;'>" . number_format($amount_paid, 2) . "</td>
                        </tr>
                        <tr>
                            <td>Adjustments:</td>
                            <td style='text-align:right;'>" . number_format($adjustment, 2) . "</td>
                        </tr>
                        <tr>
                            <td>Balance:</td>
                            <td style='text-align:right;'>" . number_format($latest_balance, 2) . "</td>
                        </tr>
                    </table>

                    <div class='line'></div>
                    <p style=\"text-align:center; font-size: 8pt; margin: 3px 0;\">
                        Please pay your unpaid bill to avoid penalties in the future
                    </p>
                    

                    <!-- Footer -->
                    <p class='center' style='font-size:7pt; margin-top:5px;'>
                        This is a system-generated receipt.<br>
                        No signature is required. Thank you!
                    </p>
                </div>
                ";


        $pdf = new TCPDF('P', 'mm', array(80, 200), true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->writeHTML($html, true, false, true, false, '');
        $fileName = "receipt_" . $transaction_reference . ".pdf";
        // $filePath = __DIR__ . "/../../files/reciepts/" . $fileName;
        $pdf->Output("receipt_" . $transaction_reference . ".pdf", "I");

        // return [
        //     "status" => "success",
        //     "file"   => "receipts/" . $fileName
        // ];
    }
    
    
    
}

?>
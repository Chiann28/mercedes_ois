<html>

<head>
    <style>
    body {
        font-family: monospace;
        font-size: 12px;
    }

    .receipt {
        width: 350px;
        margin: auto;
    }

    .center {
        text-align: center;
    }

    .line {
        border-top: 1px dashed #000;
        margin: 5px 0;
    }
    </style>
</head>

<body>

    <body>
        <div class='receipt'>
            <!-- Header with logo + company info -->
            <div class='center'
                style="display: flex; align-items: center; justify-content: center; gap: 10px; text-align: left;">
                <img src="logo_mercedes.png" alt="Company Logo" style="width:80px; height:auto;" />
                <div>
                    <h4 style="margin: 0;">BILLING INVOICE</h4>
                    <br>
                    <p style="margin: 0; max-width: 150px;">
                        Soro Soro Ilaya, Batangas City, Batangas, Philippines.<br>
                        Tel: 0912-345-6789
                    </p>
                </div>
            </div>

            <br>
            <div class='line'></div>
            <p style="text-align:center; font-size: 12px; margin: 5px 0;">
                Please pay your unpaid bill to avoid penalties in the future
            </p>
            <div class='line'></div>
            <br>
            <!-- Transaction Info -->
            <p><strong>Transaction #:</strong> PAYMENT000000000120250917125756</p>
            <p><strong>Transaction Date:</strong> 2025-09-17</p>
            <br>
            <div class='line'></div>
            <br>

            <!-- Itemized section -->
            <table style="width:100%; font-size:12px; border-collapse: collapse;">
                <tr>
                    <td style="text-align:left;"><strong>Description</strong></td>
                    <td style="text-align:right;"><strong>Price</strong></td>
                </tr>
                <tr>
                    <td>Payment for the month of September 2025</td>
                    <td style="text-align:right;">2,000.00</td>
                </tr>
            </table>
            <br>
            <div class='line'></div>

            <!-- Summary Section -->
            <table style="width:100%; font-size:13px; border-collapse: collapse;">
                <tr>
                    <td style="text-align:left; font-weight:bold;">Current Amount Due:</td>
                    <td style="text-align:right; font-weight:bold;">2,000.00</td>
                </tr>
                <tr>
                    <td>Due Date:</td>
                    <td style="text-align:right;">2025-09-30</td>
                </tr>
                <tr>
                    <td>Payment:</td>
                    <td style="text-align:right;">2,000.00</td>
                </tr>
                <tr>
                    <td>Adjustments:</td>
                    <td style="text-align:right;">0.00</td>
                </tr>
                <tr>
                    <td>Balance:</td>
                    <td style="text-align:right;">0.00</td>
                </tr>
            </table>

            <div class='line'></div>

            <!-- Footer -->
            <p style="text-align:center; font-size: 11px; margin-top:10px;">
                This is a system-generated receipt.<br>
                No signature is required. Thank you!
            </p>
        </div>
    </body>

</body>


</html>
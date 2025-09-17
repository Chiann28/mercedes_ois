<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transactions</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

    <!-- NASHIE CSS <3 -->
    <link rel="stylesheet" href="../framework/CSS/NashieCss.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
    <script src="../../mercedes_ois/admin/js/AddTransactionsController.js"></script>

</head>

<body class="mdx-body-color" ng-controller="AddTransactionsController" ng-init="VerifySession()">

    <!-- Sidebar -->
    <?php require_once '../framework/Components/mdx_sidebar.php'; ?>
    <!-- Header -->
    <?php require_once '../framework/Components/mdx_header.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="mdx-content" id="mdx_content">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- Page Bar -->
                <div class="pb-2 mb-3 border-bottom">
                    <span class="fs-12">
                        Administration • Transactions • New Transactions
                    </span>
                </div>

                <!-- Transaction Form -->
                <div class="row">

                    <!-- Customer Details -->
                    <div class="col-md-6 mb-3">
                        <div class="p-4 bg-light rounded border border-dark-subtle">
                            <div class="">
                                <h5 class="card-title fw-semibold text-muted">Customer Details</h5>
                                <div class="row mb-3 mt-3">
                                    <div class="mb-3">
                                        <label class="form-label">Accountnumber</label>
                                        <input type="text" class="form-control scarlet-focus"
                                            placeholder="Double click to select account" ng-dblclick="openModalSearch()"
                                            ng-model="customer.accountnumber" readonly>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">First name</label>
                                        <input type="text" class="form-control scarlet-focus" placeholder="First name"
                                            ng-model="customer.firstname" readonly>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Last name</label>
                                        <input type="text" class="form-control scarlet-focus" placeholder="Last name"
                                            ng-model="customer.lastname" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control scarlet-focus"
                                        placeholder="example@gmail.com" ng-model="customer.email" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone number</label>
                                    <input type="text" class="form-control scarlet-focus" placeholder="+639946205660"
                                        ng-model="customer.contact_number" readonly>
                                </div>
                                <div class="border-bottom my-5">

                                </div>
                                <div class="mb-3">
                                    <h5 class="card-title fw-semibold mb-3 text-muted">Customer Address</h5>
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control mb-2 scarlet-focus"
                                        placeholder="Country / Region" ng-model="customer.country" readonly>
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control scarlet-focus" placeholder="City"
                                                ng-model="customer.city" readonly>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Postal Code</label>
                                            <input type="text" class="form-control scarlet-focus"
                                                placeholder="Postal code" ng-model="customer.postal" readonly>
                                        </div>
                                    </div>
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control mt-2 scarlet-focus"
                                        placeholder="Street address" ng-model="customer.street" readonly>
                                    <div class="row">
                                        <div class="col mt-2">
                                            <label class="form-label">Lot Number</label>
                                            <input type="text" class="form-control scarlet-focus"
                                                placeholder="Lot Number" ng-model="customer.lot_number" readonly>
                                        </div>
                                        <div class="col mt-2">
                                            <label class="form-label">House Number</label>
                                            <input type="text" class="form-control scarlet-focus"
                                                placeholder="House Number" ng-model="customer.house_no" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction / Order Details -->
                    <div class="col-md-6 mb-3">
                        <div class="p-4 bg-light rounded border border-dark-subtle">
                            <div class="">
                                <h5 class="card-title fw-semibold mb-3 text-muted">Transaction Details</h5>

                                <div class="mb-3 text-center border rounded p-4 bg-light">
                                    <label for="transactionImage" class="form-label fw-semibold">Upload Receipt /
                                        Transaction Proof</label>
                                    <input class="form-control d-none" type="file" id="transactionImage"
                                        accept=".jpg,.jpeg,.png">

                                    <div id="uploadBox"
                                        class="border border-2 rounded d-flex flex-column justify-content-center align-items-center p-4"
                                        style="cursor: pointer;"
                                        onclick="document.getElementById('transactionImage').click();">

                                        <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-secondary"
                                            id="uploadIcon"></i>
                                        <p class="mb-0 text-muted" id="uploadText">Drop your image here, or
                                            <span class="text-primary">Click to browse</span>
                                        </p>
                                        <small class="text-muted">Accepted formats: .jpg, .jpeg, .png (min
                                            300x300px)</small>

                                        <img id="previewImage" class="mt-3 rounded shadow d-none"
                                            style="max-width: 200px; max-height: 200px;" />
                                    </div>

                                </div>
                                <div class="mb-3 border-bottom">

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Transaction Type</label>
                                    <select class="form-select scarlet-focus" ng-model="transaction_type">
                                        <option value="">Select Transaction type</option>
                                        <option value="RENT">Normal Payment</option>
                                        <option value="ADV">Advance Payment</option>
                                        <option value="MISC">Misc.</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="number" class="form-control scarlet-focus" placeholder="₱0.00"
                                        ng-model="amount_paid">
                                </div>
                                <!-- <div class="mb-3">
                                    <label class="form-label">Payment Status</label>
                                    <select class="form-select scarlet-focus" ng-model="payment_status">
                                        <option value="Paid">Paid</option>
                                        <option value="With Underpayment">With Underpayment</option>
                                        <option value="Advance Payment">Advance Payment</option>
                                    </select>
                                </div> -->

                                <button class="btn w-100 mdx-bg-scarlet" ng-click="DoPostPayment()">Save
                                    Transaction</button>
                            </div>
                        </div>
                        <div class="p-4 bg-light rounded border border-dark-subtle mt-4" style="overflow: hidden;">
                            <div class="">
                                <h5 class="card-title fw-semibold mb-3 text-muted">Last Transaction</h5>
                                <table class="table table-hover align-middle">
                                    <thead class="table-secondary text-dark">
                                        <tr>
                                            <th></th>
                                            <th>Reference Number</th>
                                            <th>Transaction Type</th>
                                            <th>Amount Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="list in LatestTransaction | filter:accountSearch"
                                            class="animate__animated animate__fadeIn">
                                            <td><i class="fa-solid fa-arrow-right text-muted"></i></td>
                                            <td>{{list.transaction_id}}</td>
                                            <td>{{list.transaction_type}}</td>
                                            <td>{{list.amount_paid | number: 2}}</td>

                                        </tr>
                                        <tr ng-if="!LatestTransaction || LatestTransaction.length === 0">
                                            <td colspan="5" class="text-center text-muted py-3">
                                                <i class="fa-regular fa-circle-xmark me-2"></i> No transactions found.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- accounts modal -->
        <div class="modal fade" id="accountSearchModal" tabindex="-1" aria-labelledby="accountSearchLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content shadow-lg border-0 rounded-4">

                    <!-- Header -->
                    <div class="modal-header bg-secondary text-white rounded-top-4">
                        <h5 class="modal-title fw-semibold" id="accountSearchLabel">
                            <i class="fa-solid fa-users me-2"></i> Select Account
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">

                        <!-- Search Bar -->
                        <div class="input-group mb-3 shadow-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" ng-model="accountSearch"
                                placeholder="Search by name or account number">
                        </div>

                        <!-- Account Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-primary text-dark">
                                    <tr>
                                        <th>Account #</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="acc in accountlist | filter:accountSearch"
                                        class="animate__animated animate__fadeIn">
                                        <td>{{acc.accountnumber}}</td>
                                        <td>{{acc.firstname}}</td>
                                        <td>{{acc.lastname}}</td>
                                        <td>{{acc.email}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                ng-click="PopulateAccountDetails(acc)" data-bs-dismiss="modal">
                                                <i class="fa-solid fa-check me-1"></i> Select
                                            </button>
                                        </td>
                                    </tr>
                                    <tr ng-if="!accountlist || accountlist.length === 0">
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="fa-regular fa-circle-xmark me-2"></i> No transactions found.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script src="../framework/JS/jsForStyling.js"></script>

</body>

</html>
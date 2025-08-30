<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adjustments</title>

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
    <script src="../../mercedes_ois/admin/js/AdjustmentsController.js"></script>

</head>

<body class="bg-light" ng-controller="AdjustmentsController" ng-init="VerifySession()">

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
                        Administration • Transactions • Adjustments
                    </span>
                </div>

                <!-- Transaction Form -->
                <div class="row">
                    <!-- Master Search -->
                    <div class="col-md-12 mb-3">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold">Master Search</h6>
                                <div class="row mb-3">
                                    <!-- <label class="form-label">Accountnumber</label> -->
                                    <div class="col-md-6 d-flex">
                                        <input type="text" class="form-control" placeholder="Search"
                                            ng-model="accountnumber">
                                        <button class="btn btn-outline-secondary mx-3" type="button"
                                            ng-click="openModalSearch()">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <button class="btn btn-secondary" type="button" ng-click="exportData()">
                                            <i class="fa fa-file-excel me-2"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Account Details-->
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-3">Account Details</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label mt-3">Accountnumber</label>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <span class="fw-bold">
                                                {{ customer.accountnumber ? customer.accountnumber : '---' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label mt-3">Full Name</label>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <span class="fw-bold">
                                                {{ customer.firstname ? customer.firstname + customer.middlename + customer.lastname : '---' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <div class="col-md-6">
                                        <label class="form-label mt-3">Block Number</label>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <span class="fw-bold">
                                                {{ customer.block_no ? customer.block_no : '---' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label mt-3">House Number</label>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <span class="fw-bold">
                                                {{ customer.house_no ? customer.house_no : '---' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label mt-3">Last Transaction Date </label>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <span class="fw-bold">
                                                {{ customer.date_registered ? customer.date_registered : '---' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Adjustments -->
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 rounded-3" style="height:320px;">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-3">Transactions</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th></th>
                                                <th>Transaction ID</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Transaction Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="t in Transactions" class="animate__animated animate__fadeIn">
                                                <td ng-click="DoAdjustment(t.transaction_id)"><i
                                                        class="fa fa-arrow-right text-muted"></i></td>
                                                <td>{{t.transaction_id}}</td>
                                                <td>{{t.transaction_type}}</td>
                                                <td>{{t.amount_paid | number: 2}}</td>
                                                <td>{{t.sysentrydate}}</td>
                                                <td>{{t.status}}</td>
                                            </tr>
                                            <tr ng-if="!Transactions || Transactions.length === 0">
                                                <td colspan="6" class="text-center text-muted">No
                                                    transactions
                                                    found.</td>
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
                                                    ng-click="GetAccountDetails(acc.accountnumber)"
                                                    data-bs-dismiss="modal">
                                                    <i class="fa-solid fa-check me-1"></i> Select
                                                </button>
                                            </td>
                                        </tr>
                                        <tr ng-if="!accountlist || accountlist.length === 0">
                                            <td colspan="4" class="text-center text-muted py-3">
                                                <i class="fa-regular fa-circle-xmark me-2"></i> No transactions
                                                found.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- adjustment modal -->
            <!-- Adjustment Modal -->
            <div class="modal fade" id="adjustmentModal" tabindex="-1" aria-labelledby="adjustmentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg border-0 rounded-3">
                        <div class="modal-header bg-secondary text-white">
                            <h5 class="modal-title fw-semibold" id="adjustmentModalLabel">
                                <i class="fa fa-edit me-2"></i> Adjustment
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Transaction Details -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Transaction ID</label>
                                <input type="text" class="form-control" ng-model="selectedTransaction.transaction_id"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Transaction Type</label>
                                <input type="text" class="form-control" ng-model="selectedTransaction.transaction_type"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Current Amount</label>
                                <input type="text" class="form-control" ng-model="selectedTransaction.amount_paid"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Adjustment Amount</label>
                                <input type="number" class="form-control" ng-model="adjustment.amount"
                                    placeholder="Enter adjustment amount">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Remarks</label>
                                <textarea class="form-control" ng-model="adjustment.remarks" rows="3"
                                    placeholder="Enter reason for adjustment"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="fa fa-times me-1"></i> Cancel
                            </button>
                            <button type="button" class="btn btn-success" ng-click="SaveAdjustment()">
                                <i class="fa fa-save me-1"></i> Save Adjustment
                            </button>
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
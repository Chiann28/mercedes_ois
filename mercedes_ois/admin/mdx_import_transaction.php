<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Transactions</title>

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
    <script src="../../mercedes_ois/admin/js/ImportTransactionController.js"></script>

</head>

<body class="bg-light" ng-controller="ImportTransactionController" ng-init="VerifySession();
                                                                            GetPaymentImport();">

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
                        Administration • Transactions • Import
                    </span>
                </div>

                <!-- Upload Section -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3"><i class="fa fa-file-import me-2"></i> Upload File</h6>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <input type="file" class="form-control" id="fileInput" file-model="file">
                            </div>

                            <div class="col-md-3">
                                <input type="date" class="form-control" ng-model="importDate"
                                    ng-change="GetPaymentImport()" placeholder="Transaction Date">
                            </div>
                            <div class="col-md-3 text-end">
                                <button class="btn btn-primary" ng-click="importTransactions()">
                                    <i class="fa fa-upload me-2"></i> Import
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Imported Transactions Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0"><i class="fa fa-table me-2"></i> Imported Transactions</h6>
                            <div>
                                <button class="btn btn-danger btn-sm me-2" ng-click="deleteSelected()">
                                    <i class="fa fa-trash me-1"></i> Delete Selected
                                </button>
                                <button class="btn btn-success btn-sm" ng-click="postTransactions()">
                                    <i class="fa fa-paper-plane me-1"></i> Post Transactions
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <input type="text" class="form-control" ng-model="searchText"
                                placeholder="Search transactions...">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>
                                            <input type="checkbox" ng-model="selectAll" id="selectAllBox"
                                                ng-change="toggleAll()">
                                        </th>
                                        <th>Transaction ID</th>
                                        <th>Accountnumber</th>
                                        <th>Imported Date</th>
                                        <th>Amount</th>
                                        <th>Provider</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="t in ImportedTransactions | filter:searchText"
                                        class="animate__animated animate__fadeIn">
                                        <td>
                                            <input type="checkbox" ng-model="t.selected" ng-click="toggleOne()"
                                                ng-disabled="t.status.toLowerCase() === 'posted'">
                                        </td>
                                        <td>{{t.transaction_id}}</td>
                                        <td>{{t.accountnumber}}</td>
                                        <td>{{t.payment_date}}</td>
                                        <td>{{t.payment | number: 2}}</td>
                                        <td>{{t.source}}</td>
                                        <td>
                                            <span class=" badge" ng-class="{
                                                'bg-success': t.status.toLowerCase() === 'posted',
                                                'bg-secondary': t.status.toLowerCase() !== 'posted'
                                            }">
                                                {{ t.status | uppercase }}</span>
                                        </td>
                                        <td>{{t.remarks}}</td>
                                    </tr>
                                    <tr ng-if="!ImportedTransactions || ImportedTransactions.length === 0">
                                        <td colspan="8" class="text-center text-muted py-3">
                                            <i class="fa-regular fa-circle-xmark me-2"></i> No imported transactions
                                            yet.
                                        </td>
                                    </tr>
                                </tbody>


                            </table>
                        </div>

                    </div>
                </div>

            </div>


            <!-- Results Modal -->
            <div class="modal fade" id="importResultsModal" tabindex="-1" role="dialog"
                aria-labelledby="importResultsLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="importResultsLabel">Import Results</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="resultsTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="success-tab" data-bs-toggle="tab"
                                        data-bs-target="#successTabPane" type="button" role="tab">
                                        Success ({{successData.length}})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="fail-tab" data-bs-toggle="tab"
                                        data-bs-target="#failTabPane" type="button" role="tab">
                                        Fail ({{failData.length}})
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content mt-3">
                                <!-- Success Table -->
                                <div class="tab-pane fade show active" id="successTabPane" role="tabpanel">
                                    <table class="table table-sm table-bordered" ng-if="successData.length > 0">
                                        <thead>
                                            <tr>
                                                <th>Account Number</th>
                                                <th>Reference</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="row in successData">
                                                <td>{{row[0]}}</td>
                                                <td>{{row[1]}}</td>
                                                <td>{{row[3]}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p ng-if="successData.length == 0">No successful records.</p>
                                </div>

                                <!-- Fail Table -->
                                <div class="tab-pane fade" id="failTabPane" role="tabpanel">
                                    <table class="table table-sm table-bordered" ng-if="failData.length > 0">
                                        <thead>
                                            <tr>
                                                <th>Account #</th>
                                                <th>Reference</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="row in failData">
                                                <td>{{row[0]}}</td>
                                                <td>{{row[1]}}</td>
                                                <td>{{row[2]}}</td>
                                                <td>{{row[3]}}</td>
                                                <td>{{row[4]}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p ng-if="failData.length == 0">No failed records.</p>
                                </div>
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
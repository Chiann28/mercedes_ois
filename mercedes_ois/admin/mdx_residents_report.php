<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts Ledger</title>

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
    <script src="../../mercedes_ois/admin/js/AdminReportsController.js"></script>

    <!-- Export to excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <style>
    .ref-col {
        max-width: 190px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }

    .ref-col:hover {
        white-space: normal;
        overflow: visible;
        position: relative;
        z-index: 1;
    }
    </style>

</head>

<body class="bg-light" ng-controller="AdminReportsController" ng-init="VerifySession()">

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
                    <span class="fs-12">Administration • Reports • Resident Masterlist</span>
                </div>

                <!-- Filters -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Filter Residents</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" ng-model="status">
                                    <option value="">All</option>
                                    <option value="ACTIVE">Active</option>
                                    <option value="INACTIVE">Inactive</option>
                                    <option value="TERMINATED">Terminated</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Registered From</label>
                                <input type="date" class="form-control" ng-model="datefrom">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Registered To</label>
                                <input type="date" class="form-control" ng-model="dateto">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100" ng-click="GetReport('resident_masterlist')">
                                    <i class="fa fa-search me-2"></i> Generate Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-success me-2" ng-click="ExportExcel('residents')">
                        <i class="fa fa-file-excel me-1"></i> Export Excel
                    </button>
                    <!-- <button class="btn btn-danger" ng-click="ExportPDF()">
                        <i class="fa fa-file-pdf me-1"></i> Export PDF
                    </button> -->
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3" ng-repeat="card in summaryCards">
                        <div class="card shadow-sm border-start border-4 border-primary p-3">
                            <h6 class="text-muted">{{card.title}}</h6>
                            <h4 class="fw-bold">{{card.value}}</h4>
                        </div>
                    </div>
                </div>

                <!-- Resident Masterlist Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Resident Masterlist</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Account #</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Lot #</th>
                                        <th>House #</th>
                                        <th>Status</th>
                                        <th>Date Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="r in data">
                                        <td>{{r.accountnumber}}</td>
                                        <td>{{r.firstname}} {{r.middlename}} {{r.lastname}}</td>
                                        <td>{{r.email}}</td>
                                        <td>{{r.contact_number}}</td>
                                        <td>{{r.lot_number}}</td>
                                        <td>{{r.house_no}}</td>
                                        <td>
                                            <span class="badge bg-success"
                                                ng-if="r.status=='ACTIVE'">{{r.status}}</span>
                                            <span class="badge bg-secondary"
                                                ng-if="r.status=='INACTIVE'">{{r.status}}</span>
                                            <span class="badge bg-danger"
                                                ng-if="r.status=='TERMINATED'">{{r.status}}</span>
                                        </td>
                                        <td>{{r.registration_date}}</td>
                                    </tr>
                                    <tr ng-if="!data || data.length==0">
                                        <td colspan="8" class="text-center text-muted">No residents found.</td>
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
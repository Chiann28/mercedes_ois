<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Report</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../framework/CSS/NashieCss.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
    <script src="../../mercedes_ois/admin/js/AdminReportsController.js"></script>

    <style>
    .desc-col {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }

    .desc-col:hover {
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
                    <span class="fs-12">Administration • Reports • Events</span>
                </div>

                <!-- Filters -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Filter Events</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Event Type</label>
                                <select class="form-select" ng-model="event_type">
                                    <option value="">All</option>
                                    <option value="Celebration">Celebration</option>
                                    <option value="Birthday">Birthday</option>
                                    <option value="Seminar">Seminar</option>
                                    <option value="Environmental">Environmental</option>
                                    <option value="Funeral">Funeral / Burial</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Date Created From</label>
                                <input type="date" class="form-control" ng-model="datefrom">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Created To</label>
                                <input type="date" class="form-control" ng-model="dateto">
                            </div>
                            <div class="col-md-3 mt-4">
                                <button class="btn btn-primary w-100" ng-click="GetReport('events')">
                                    <i class="fa fa-search me-2"></i> Generate Report
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Export Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-success me-2" ng-click="ExportExcel()">
                        <i class="fa fa-file-excel me-1"></i> Export Excel
                    </button>
                    <button class="btn btn-danger" ng-click="ExportPDF()">
                        <i class="fa fa-file-pdf me-1"></i> Export PDF
                    </button>
                </div>

                <!-- Summary Cards -->
                <div class="row my-4">
                    <div class="col-md-3" ng-repeat="card in summaryCards">
                        <div class="card shadow-sm border-start border-4 border-primary p-3">
                            <h6 class="text-muted">{{card.title}}</h6>
                            <h4 class="fw-bold">{{card.value}}</h4>
                        </div>
                    </div>
                </div>

                <!-- Events Table -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Event Records</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Event Name</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Initiated By</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="e in data">
                                        <td>{{e.start_date}}</td>
                                        <td>{{e.end_date}}</td>
                                        <td>{{e.event_name}}</td>
                                        <td>{{e.event_type}}</td>
                                        <td class="desc-col">{{e.event_description}}</td>
                                        <td>{{e.initiated_by}}</td>
                                        <td>{{e.location}}</td>
                                        <td>
                                            <!-- <span class="badge bg-info text-dark"
                                                ng-if="e.status=='UPCOMING'">{{e.status}}</span>
                                            <span class="badge bg-warning text-dark"
                                                ng-if="e.status=='ONGOING'">{{e.status}}</span>
                                            <span class="badge bg-success"
                                                ng-if="e.status=='COMPLETED'">{{e.status}}</span>
                                            <span class="badge bg-danger"
                                                ng-if="e.status=='CANCELLED'">{{e.status}}</span> -->
                                            {{e.event_status}}
                                        </td>
                                    </tr>
                                    <tr ng-if="!data || data.length==0">
                                        <td colspan="8" class="text-center text-muted">No event records found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../framework/JS/jsForStyling.js"></script>

</body>

</html>
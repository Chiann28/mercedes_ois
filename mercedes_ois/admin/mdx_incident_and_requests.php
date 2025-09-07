<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request and Reports</title>
    <!-- Custom CSS -->
    <style>
        .nav-pills .nav-link.active {
            background-color: #f55355 !important;
            /* Gray background */
            color: #fff !important;
            /* White text */
        }

        .nav-pills .nav-link {
            margin-right: 5px;
            border-radius: 5px;
        }
    </style>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">



    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
    <script src="../../mercedes_ois/admin/js/IncidentAndRequestController.js"></script>

    <!-- NASHIE CSS <3 -->
    <link rel="stylesheet" href="../framework/CSS/NashieCss.css">
    
</head>

<body class="mdx-body-color" ng-controller="IncidentAndRequestController" ng-init="VerifySession();
                                                                            GetRequestAndIncidents();">

    <!-- Sidebar -->
    <?php require_once '../framework/Components/mdx_sidebar.php'; ?>
    <!-- Header -->
    <?php require_once '../framework/Components/mdx_header.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="mdx-content" id="mdx_content">
        <div class="container-fluid">
            <!-- Page Bar -->
            <div class="pb-2 mb-3 border-bottom">
                <span class="fs-12">
                    Administration • Incidents and Requests
                </span>
            </div>
            <div class="col-md-12 mt-3">

                <div class="col-md-12">

                    <div class="p-4 bg-light rounded border border-dark-subtle">
                        <!-- Tabs for filtering by status -->
                        <ul class="nav nav-pills" id="reportTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active text-dark " id="all-tab" data-bs-toggle="tab"
                                    data-bs-target="#all" type="button">All</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-dark" id="new-tab" data-bs-toggle="tab"
                                    data-bs-target="#new" type="button">New</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-dark" id="progress-tab" data-bs-toggle="tab"
                                    data-bs-target="#in-progress" type="button">In Progress</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-dark" id="resolved-tab" data-bs-toggle="tab"
                                    data-bs-target="#resolved" type="button">Resolved</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-dark" id="closed-tab" data-bs-toggle="tab"
                                    data-bs-target="#closed" type="button">Closed</button>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="col-md-12 mt-4">
                    <div class="p-4 bg-light rounded border border-dark-subtle">




                        <!-- Filter Bar -->
                        <div class="d-md-flex justify-content-md-between mb-3">
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control scarlet-focus" placeholder="Search">
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-select scarlet-focus" ng-model="filter.type">
                                        <option value="">All Types</option>
                                        <option value="incident">Incident</option>
                                        <option value="request">Request</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select scarlet-focus" ng-model="filter.status">
                                        <option value="">All Status</option>
                                        <option value="New">New</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Resolved">Resolved</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select scarlet-focus" ng-model="filter.priority">
                                        <option value="">All Priorities</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                        <option value="Urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content" id="reportTabsContent">

                            <!-- All Reports -->
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border shadow-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Date Reported</th>
                                                <th scope="col">Requested By</th>
                                                <th scope="col">Date Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in listAll | filter:filter.type | filter:filter.status | filter:filter.priority"
                                                ng-click="openModal(list)" style="cursor: pointer;">
                                                <td ng-bind="list.id"></td>
                                                <td>
                                                    <span class="badge rounded-pill p-2 text-light" ng-class="{
                                                        'mdx-bg-red-300' : list.type == 'incident',
                                                        'mdx-bg-blue-300' : list.type == 'request'
                                                        }" ng-bind="list.type | uppercase"></span>
                                                </td>
                                                <td ng-bind="list.category | uppercase"></td>
                                                <td ng-bind="list.title | uppercase"></td>
                                                <td>
                                                    <span ng-class="{
                                                            'text-success': list.priority == 'Low',
                                                            'text-primary': list.priority == 'Medium',
                                                            'text-danger': list.priority == 'High',
                                                            'text-warning': list.priority == 'Urgent'
                                                        }" ng-bind="list.priority | uppercase"></span>
                                                </td>
                                                <td>
                                                    <span ng-class="{
                                                        'text-secondary': list.status == 'New',
                                                        'text-info': list.status == 'In Progress',
                                                        'text-success': list.status == 'Resolved',
                                                        'text-dark': list.status == 'Closed'
                                                    }" ng-bind="list.status"></span>
                                                </td>
                                                <td ng-bind="list.location"></td>
                                                <td ng-bind="list.sysentrydate"></td>
                                                <td ng-bind="list.requested_by"></td>
                                                <td ng-bind="list.modifieddate"></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- New Reports -->
                            <div class="tab-pane fade" id="new" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Date Reported</th>
                                                <th scope="col">Requested By</th>
                                                <th scope="col">Date Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in listNew| filter:filter.type | filter:filter.status | filter:filter.priority"
                                                ng-click="openModal(list)" style="cursor: pointer;">
                                                <td ng-bind="list.id"></td>
                                                <td>
                                                    <span class="badge rounded-pill p-2 text-light" ng-class="{
                                                        'mdx-bg-red-300' : list.type == 'incident',
                                                        'mdx-bg-blue-300' : list.type == 'request'
                                                        }" ng-bind="list.type | uppercase"></span>
                                                </td>
                                                <td ng-bind="list.category| uppercase"></td>
                                                <td ng-bind="list.title| uppercase"></td>
                                                <td>
                                                    <span class="" ng-class="{
                                                            'text-success': list.priority == 'Low',
                                                            'text-primary': list.priority == 'Medium',
                                                            'text-danger': list.priority == 'High',
                                                            'text-warning': list.priority == 'Urgent'
                                                        }" ng-bind="list.priority | uppercase">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="" ng-class="{
                                                            'text-secondary': list.status == 'New',
                                                        'text-info': list.status == 'In Progress',
                                                        'text-success': list.status == 'Resolved',
                                                        'text-dark': list.status == 'Closed'
                                                        }" ng-bind="list.status">
                                                    </span>
                                                </td>
                                                <td ng-bind=" list.location"></td>
                                                <td ng-bind="list.sysentrydate"></td>
                                                <td ng-bind="list.requested_by"></td>
                                                <td ng-bind="list.modifieddate"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- In Progress -->
                            <div class="tab-pane fade" id="in-progress" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Date Reported</th>
                                                <th scope="col">Requested By</th>
                                                <th scope="col">Date Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in listInprogress 
                                                                | filter:filter.type 
                                                                | filter:filter.status 
                                                                | filter:filter.priority" ng-click="openModal(list)"
                                                style="cursor: pointer;">
                                                <td ng-bind="list.id"></td>

                                                <!-- TYPE Badge -->
                                                <td>
                                                    <span class="badge rounded-pill p-2 text-light" ng-class="{
                                                        'mdx-bg-red-300' : list.type == 'incident',
                                                        'mdx-bg-blue-300' : list.type == 'request'
                                                        }" ng-bind="list.type | uppercase"></span>
                                                </td>

                                                <td ng-bind="list.category | uppercase"></td>
                                                <td ng-bind="list.title | uppercase"></td>

                                                <!-- PRIORITY Badge -->
                                                <td>
                                                    <span ng-class="{
                                                            'text-success': list.priority == 'Low',
                                                            'text-primary': list.priority == 'Medium',
                                                            'text-danger': list.priority == 'High',
                                                            'text-warning': list.priority == 'Urgent'
                                                        }" ng-bind="list.priority | uppercase">
                                                    </span>
                                                </td>

                                                <!-- STATUS Badge -->
                                                <td>
                                                    <span ng-class="{
                                                        'text-secondary': list.status == 'New',
                                                        'text-info': list.status == 'In Progress',
                                                        'text-success': list.status == 'Resolved',
                                                        'text-dark': list.status == 'Closed'
                                                    }" ng-bind="list.status"></span>
                                                </td>

                                                <td ng-bind="list.location"></td>
                                                <td ng-bind="list.sysentrydate"></td>
                                                <td ng-bind="list.requested_by"></td>
                                                <td ng-bind="list.modifieddate"></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Resolved -->
                            <div class="tab-pane fade" id="resolved" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Date Reported</th>
                                                <th scope="col">Requested By</th>
                                                <th scope="col">Date Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in listResolved
                                                                | filter:filter.type 
                                                                | filter:filter.status 
                                                                | filter:filter.priority" ng-click="openModal(list)"
                                                style="cursor: pointer;">
                                                <td ng-bind="list.id"></td>

                                                <!-- TYPE Badge -->
                                                <td>
                                                    <span class="badge rounded-pill p-2 text-light" ng-class="{
                                                        'mdx-bg-red-300' : list.type == 'incident',
                                                        'mdx-bg-blue-300' : list.type == 'request'
                                                        }" ng-bind="list.type | uppercase"></span>
                                                </td>

                                                <td ng-bind="list.category | uppercase"></td>
                                                <td ng-bind="list.title | uppercase"></td>

                                                <!-- PRIORITY Badge -->
                                                <td>
                                                    <span ng-class="{
                                                            'text-success': list.priority == 'Low',
                                                            'text-primary': list.priority == 'Medium',
                                                            'text-danger': list.priority == 'High',
                                                            'text-warning': list.priority == 'Urgent'
                                                        }" ng-bind="list.priority | uppercase"></span>
                                                </td>

                                                <!-- STATUS Badge -->
                                                <td>
                                                    <span ng-class="{
                                                        'text-secondary': list.status == 'New',
                                                        'text-info': list.status == 'In Progress',
                                                        'text-success': list.status == 'Resolved',
                                                        'text-dark': list.status == 'Closed'
                                                    }" ng-bind="list.status">
                                                    </span>
                                                </td>

                                                <td ng-bind="list.location"></td>
                                                <td ng-bind="list.sysentrydate"></td>
                                                <td ng-bind="list.requested_by"></td>
                                                <td ng-bind="list.modifieddate"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Closed -->
                            <div class="tab-pane fade" id="closed" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Date Reported</th>
                                                <th scope="col">Requested By</th>
                                                <th scope="col">Date Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in listClosed 
                                                                | filter:filter.type 
                                                                | filter:filter.status 
                                                                | filter:filter.priority" ng-click="openModal(list)"
                                                style="cursor: pointer;">
                                                <td ng-bind="list.id"></td>

                                                <!-- TYPE Badge -->
                                                <td>
                                                    <span class="badge rounded-pill p-2 text-light" ng-class="{
                                                        'mdx-bg-red-300' : list.type == 'incident',
                                                        'mdx-bg-blue-300' : list.type == 'request'
                                                        }" ng-bind="list.type | uppercase"></span>
                                                </td>

                                                <td ng-bind="list.category | uppercase"></td>
                                                <td ng-bind="list.title | uppercase"></td>

                                                <!-- PRIORITY Badge -->
                                                <td>
                                                    <span ng-class="{
                                                            'text-success': list.priority == 'Low',
                                                            'text-primary': list.priority == 'Medium',
                                                            'text-danger': list.priority == 'High',
                                                            'text-warning': list.priority == 'Urgent'
                                                        }" ng-bind="list.priority | uppercase">
                                                    </span>
                                                </td>

                                                <!-- STATUS Badge -->
                                                <td>
                                                    <span ng-class="{
                                                        'text-secondary': list.status == 'New',
                                                        'text-info': list.status == 'In Progress',
                                                        'text-success': list.status == 'Resolved',
                                                        'text-dark': list.status == 'Closed'
                                                    }" ng-bind="list.status">
                                                    </span>
                                                </td>

                                                <td ng-bind="list.location"></td>
                                                <td ng-bind="list.sysentrydate"></td>
                                                <td ng-bind="list.requested_by"></td>
                                                <td ng-bind="list.modifieddate"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Details Modal -->
            <div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <!-- xl for wider modal -->
                    <div class="modal-content border-0 shadow-lg rounded-3">
                        <div class="modal-header border-0 pb-0 border-bottom">
                            <div>
                                <h5 class="modal-title fw-bold" ng-bind="selectedItem.title"></h5>
                                <small class="text-muted" ng-bind="selectedItem.category | uppercase"></small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">

                                <!-- LEFT SIDE (Details) -->
                                <div class="col-md-7 border-end pe-3">
                                    <div class="mb-3">
                                        <label class="fw-semibold text-uppercase small">Title</label>
                                        <div class="text-dark fw-bold" style="white-space: pre-line;"
                                            ng-bind="selectedItem.title"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-semibold text-uppercase small">Issue Description</label>
                                        <textarea class="form-control text-dark scarlet-focus" ng-model="selectedItem.description"
                                            rows="4" placeholder="Enter issue description here..."></textarea>
                                    </div>

                                    <!-- Priority -->
                                    <div class="mb-3">
                                        <label class="fw-semibold text-uppercase small">Priority</label>
                                        <div class="dropdown">
                                            <span class="badge px-3 py-2 dropdown-toggle" role="button"
                                                data-bs-toggle="dropdown" ng-class="{
                                                    'bg-success': selectedItem.priority == 'Low',
                                                    'bg-primary': selectedItem.priority == 'Medium',
                                                    'bg-warning text-dark': selectedItem.priority == 'High',
                                                    'bg-danger': selectedItem.priority == 'Urgent'
                                                }">
                                                {{selectedItem.priority}}
                                            </span>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.priority='Low'">Low</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.priority='Medium'">Medium</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.priority='High'">High</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.priority='Urgent'">Urgent</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label class="fw-semibold text-uppercase small">Status</label>
                                        <div class="dropdown">
                                            <span class="badge px-3 py-2 dropdown-toggle" role="button"
                                                data-bs-toggle="dropdown" ng-class="{
                                                        'bg-secondary': selectedItem.status == 'New',
                                                        'bg-info text-dark': selectedItem.status == 'In Progress',
                                                        'bg-success': selectedItem.status == 'Resolved',
                                                        'bg-dark': selectedItem.status == 'Closed'
                                                    }">
                                                {{selectedItem.status}}
                                            </span>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.status='New'">New</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.status='In Progress'">In Progress</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.status='Resolved'">Resolved</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        ng-click="selectedItem.status='Closed'">Closed</a></li>
                                            </ul>
                                        </div>
                                    </div>


                                    <!-- Requested By -->
                                    <div class="mb-3">
                                        <label class="fw-semibold text-uppercase small">Requested By</label>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{selectedItem.requested_by}}&background=random"
                                                alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                            <span ng-bind="selectedItem.requested_by"></span>
                                        </div>
                                    </div>

                                    <!-- Dates -->
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <label class="fw-semibold text-uppercase small">Created At</label>
                                            <input type="date" class="form-control" ng-model="selectedItem.sysentrydate"
                                                disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fw-semibold text-uppercase small">Last Modified</label>
                                            <input type="date" class="form-control" ng-model="selectedItem.modifieddate"
                                                disabled>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="fw-semibold text-uppercase small">Date Completed</label>
                                            <input type="date" class="form-control scarlet-focus"
                                                ng-model="selectedItem.resolved_date">
                                        </div>
                                    </div>
                                </div>


                                <!-- RIGHT SIDE (Comments) -->
                                <div class="col-md-5 ps-3"
                                    style="background: linear-gradient(135deg, #f5f7fa 0%, #e6e9f0 100%); border-left: 1px solid #ddd;">
                                    <div class="mb-2"></div>
                                    <h6 class="fw-bold mb-3 mt-2">Comments</h6>

                                    <!-- Comments List -->
                                    <div class="comments-box mb-3 p-2" style="max-height: 300px; overflow-y: auto;">
                                        <div class="mb-2 p-2 shadow-sm" ng-repeat="c in comments">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name={{selectedItem.requested_by}}&background=random"
                                                    alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                                <span ng-bind="selectedItem.requested_by"></span>
                                                <span>: &nbsp;</span>
                                                <div class="text-dark">{{c.description}}</div>
                                            </div>

                                        </div>
                                        <!-- If no comments -->
                                        <div ng-if="!comments || comments.length === 0" class="text-muted small">
                                            Be the first one to add a comment</div>
                                    </div>

                                    <!-- Comment Input -->
                                    <div class="input-group">
                                        <input type="text" class="form-control scarlet-focus" placeholder="Write a comment..."
                                            ng-model="comment">
                                        <button class="btn btn-primary" type="button"
                                            ng-click="DoPostComment(selectedItem.id)">Send</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" ng-click="DoSaveChanges(selectedItem)">Save
                                Changes</button>
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
<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement Tab</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

    <!-- NASHIE CSS <3 -->
    <link rel="stylesheet" href="../framework/CSS/NashieCss.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
    <script src="../../mercedes_ois/admin/js/AnnouncementController.js"></script>

</head>

<body class="mdx-body-color" ng-controller="AnnouncementController" ng-init="VerifySession(); GetAnnouncements();">

    <!-- Sidebar -->
    <?php require_once '../framework/Components/mdx_sidebar.php'; ?>
    <!-- Header -->
    <?php require_once '../framework/Components/mdx_header.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="mdx-content pt-5 mt-5" id="mdx_content">
        <div class="container-fluid">
            <!-- <span>Start Coding Here</span>
            <span>Start Coding Here</span>
            <span>Start Coding Here</span> -->

            <div class="col-md-12">
                <!-- Page Bar -->
                <div class="pb-2 mb-3 border-bottom">
                    <span class="fs-12">
                        Administration • Announcement • Manage Announcements
                    </span>
                </div>
                <!-- Master Search -->
                <div class="row">


                    <div class="col-md-12 mb-4">

                        <div class="border border-dark-subtle rounded p-4 bg-light">
                            <div class="row">
                                <!-- Announcement Status Cards (Full Width) -->
                                <div class="col-md-12">
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="card border-0 shadow-sm rounded-3 bg-white">
                                                <div class="card-body text-center">
                                                    <div class="mb-2">
                                                        <i class="fa-solid fa-bullhorn fa-2x text-primary"></i>
                                                    </div>
                                                    <h6 class="fw-semibold text-secondary">Active Announcements</h6>
                                                    <h4 class="fw-bold text-primary mb-0">{{activeCount}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-0 shadow-sm rounded-3 bg-white">
                                                <div class="card-body text-center">
                                                    <div class="mb-2">
                                                        <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                                                    </div>
                                                    <h6 class="fw-semibold text-secondary">Closed Announcements</h6>
                                                    <h4 class="fw-bold text-danger mb-0">{{closedCount}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-0 shadow-sm rounded-3 bg-white">
                                                <div class="card-body text-center">
                                                    <div class="mb-2">
                                                        <i class="fa-solid fa-file-pen fa-2x text-warning"></i>
                                                    </div>
                                                    <h6 class="fw-semibold text-secondary">Drafts</h6>
                                                    <h4 class="fw-bold text-warning mb-0">0</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card border-0 shadow-sm rounded-3 bg-white">
                                                <div class="card-body text-center">
                                                    <div class="mb-2">
                                                        <i class="fa-solid fa-calendar-check fa-2x text-success"></i>
                                                    </div>
                                                    <h6 class="fw-semibold text-secondary">Scheduled</h6>
                                                    <h4 class="fw-bold text-success mb-0">{{scheduledCount}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Announcement Status Cards -->

                                <!-- Search and Add Button -->
                                <div class="col-md-8 col-lg-6">
                                    <div class="input-group d-flex">
                                        <input type="text" class="form-control" placeholder="Search for announcement"
                                            ng-model="search">
                                    </div>
                                </div>

                                <div
                                    class="col-md-4 col-lg-6 d-flex align-items-center justify-content-end mt-3 mt-md-0">
                                    <button class="btn btn-secondary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#newAnnouncementModal">
                                        <i class="fa fa-plus me-2"></i> Add new announcement
                                    </button>
                                </div>
                                <!-- End Search and Add Button -->
                            </div>
                        </div>
                        <!-- Minimal Toolbar (Sort / Group / Share) -->
                        <div class="d-flex justify-content-start align-items-center mt-3 gap-4">

                            <!-- Sort By -->
                            <div class="dropdown me-3">
                                <a class="text-muted text-decoration-none dropdown-toggle small" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Sort By
                                </a>
                                <ul class="dropdown-menu shadow-sm">
                                    <li><a class="dropdown-item small" href="" ng-click="setSort('title', false)">Title
                                            (A–Z)</a></li>
                                    <li><a class="dropdown-item small" href="" ng-click="setSort('title', true)">Title
                                            (Z–A)</a></li>
                                    <li><a class="dropdown-item small" href=""
                                            ng-click="setSort('sysentrydate', true)">Date Created</a></li>
                                    <li><a class="dropdown-item small" href=""
                                            ng-click="setSort('scheduled_date', false)">Scheduled Date</a></li>
                                </ul>
                            </div>

                            <!-- Group By -->
                            <div class="dropdown">
                                <a class="text-muted text-decoration-none dropdown-toggle small" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Group By: {{groupBy | uppercase}}
                                </a>
                                <ul class="dropdown-menu shadow-sm">
                                    <li><a class="dropdown-item small" href="" ng-click="setGroup('status')">Status</a>
                                    </li>
                                    <li><a class="dropdown-item small" href=""
                                            ng-click="setGroup('scheduled_date')">Date</a></li>
                                    <li><a class="dropdown-item small" href=""
                                            ng-click="setGroup('modifiedby')">Modified By</a></li>
                                </ul>
                            </div>


                            <!-- Share -->
                            <div class="dropdown">
                                <a class="text-muted text-decoration-none dropdown-toggle small" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Export
                                </a>
                                <ul class="dropdown-menu shadow-sm">
                                    <li><a class="dropdown-item small" href="#">Export to Excel</a></li>
                                </ul>
                            </div>

                        </div>

                        <!-- Announcements Grid -->
                        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                            <!-- ng-repeat announcement card -->
                            <div class="col" ng-repeat="a in listAll | orderBy:sortKey:sortReverse | filter:search"
                                ng-click="openModal(a)">
                                <div class=" card h-100 border-0 shadow-sm rounded-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6"><small class="text-muted">Announcement</small></div>
                                            <div class="col-md-6"><small class="text-muted">{{a.sysentrydate}}</small>
                                            </div>
                                        </div>
                                        <h6 class="fw-semibold mt-2">{{ a.title }}</h6>
                                        <p class="text-muted small">{{ a.message }}</p>

                                        <div class="d-flex justify-content-start align-items-center mt-3 gap-3">
                                            <i class="fa-regular fa-calendar text-secondary"></i>
                                            <i class="fa-regular fa-folder text-secondary"></i>
                                            <i class="fa-regular fa-user text-secondary"></i>
                                            <i class="fa-regular fa-message text-secondary"></i>
                                        </div>
                                    </div>

                                    <div
                                        class="card-footer bg-white border-0 d-flex justify-content-start align-items-center gap-2">
                                        <span class="badge" ng-class="{
                                            'bg-primary': a.status=='ACTIVE',
                                            'bg-danger': a.status=='CLOSED',
                                            'bg-warning text-dark': a.status=='DRAFT',
                                             'bg-warning text-dark': a.status=='PENDING',
                                            'bg-success': a.status=='SCHEDULED'
                                        }">
                                            {{ a.status }}
                                        </span>
                                        <span class="badge bg-light text-dark">{{ a.modifiedby }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Announcements Grid -->
                    </div>
                    <!-- Add New Announcement Modal -->
                    <div class="modal fade" id="newAnnouncementModal" tabindex="-1"
                        aria-labelledby="newAnnouncementModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow rounded-3">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title fw-semibold" id="newAnnouncementModalLabel">
                                        <i class="fa fa-bullhorn me-2 text-secondary"></i> Add New Announcement
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form ng-submit="DoAddAnnouncement()" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <!-- Title -->
                                            <div class="col-md-12">
                                                <label class="form-label small fw-semibold">Title</label>
                                                <input type="text" class="form-control" ng-model="newAnnouncement.title"
                                                    placeholder="Enter announcement title" required>
                                            </div>

                                            <!-- Message -->
                                            <div class="col-md-12">
                                                <label class="form-label small fw-semibold">Message</label>
                                                <textarea class="form-control" ng-model="newAnnouncement.message"
                                                    rows="3" placeholder="Enter announcement details"></textarea>
                                            </div>

                                            <!-- Scheduled Date -->
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold">Scheduled Date</label>
                                                <input type="date" class="form-control"
                                                    ng-model="newAnnouncement.scheduled_date">
                                            </div>

                                            <!-- File Upload (Multiple Attachments) -->
                                            <div class="col-md-12">
                                                <label class="form-label small fw-semibold">Attachments</label>
                                                <input type="file" class="form-control" multiple
                                                    onchange="angular.element(this).scope().setFiles(this)">
                                                <small class="text-muted">You can upload multiple files (PDF, Images,
                                                    Docs).</small>

                                                <!-- Preview list -->
                                                <ul class="mt-2 small text-muted">
                                                    <li ng-repeat="file in newAnnouncement.attachments">{{file.name}}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            data-bs-dismiss="modal">
                                            <i class="fa fa-times me-1"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa fa-save me-1"></i> Save Announcement
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL-->
                    <!-- EDIT Modal -->
                    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog"
                        aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">

                                <!-- Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Edit Announcement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Body -->
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3" ng-if="announcement_attachment.length > 0">
                                            <label class="form-label">Attachments</label>
                                            <div class="row g-2">
                                                <div class="col-md-4" ng-repeat="file in announcement_attachment">
                                                    <div class="card border-0 shadow-sm">
                                                        <img ng-src="{{ announcementBasePath + file.filename }}"
                                                            class="img-fluid rounded-top" alt="Attachment Image">

                                                        <div class="card-body p-2">
                                                            <small
                                                                class="text-truncate d-block">{{ file.filename }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control"
                                                ng-model="selectedAnnouncement.title">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Message</label>
                                            <textarea class="form-control" rows="4"
                                                ng-model="selectedAnnouncement.message"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" ng-model="selectedAnnouncement.status">
                                                <option value="DRAFT">Draft</option>
                                                <option value="ACTIVE">Active</option>
                                                <option value="SCHEDULED">Scheduled</option>
                                                <option value="CLOSED">Closed</option>
                                                <option value="PENDING">Pending</option>
                                                <option value="POSTED">Posted</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Scheduled Date</label>
                                            <input type="date" class="form-control"
                                                ng-model="selectedAnnouncement.scheduled_date">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success"
                                        ng-click="DoUpdateAnnouncement()">Post</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- END MODAL-->

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
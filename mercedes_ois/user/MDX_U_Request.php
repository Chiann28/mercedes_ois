<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
  <meta charset="UTF-8">
  <title>MERCEDEX</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>

  <script src="../../mercedes_ois/user/js/U_IncidentAndRequestController.js"></script>


  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss-Frontend.css">
  <link rel="stylesheet" href="../framework/CSS/user_dashboard_anims.css">
</head>

<body class="bg-light" style="" ng-controller="U_IncidentAndRequestController" ng-init="init('request');">
  <?php require_once '../framework/Components/mdx_user_header.php'; ?>

  <div class="container-md mb-3 py-5" style="min-height: 87vh">
    <div class="p-5 mt-3 shadow-sm rounded border d-flex justify-content-between align-items-center">
      <h1 class="fw-semiboold"><i class="fa-solid fa-bell-concierge lower-card-icon-rotate me-1"></i>Requests</h1>
      <div>
        <!-- <button class="btn btn-secondary btn-sm" type="button" ng-click="InitializeUpdating()">
          <i class="fa-solid fa-xmark" ng-if="isEditing"></i>
          <i class="fa-solid fa-user-pen" ng-if="!isEditing"></i>

        </button> -->
      </div>

    </div>

    <div class="p-5 py-3 mt-3 shadow-sm rounded border">

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
            Request
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
            type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
            History
          </button>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content mt-3" id="myTabContent">

        <div class="tab-pane my-4 fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
          tabindex="0">
          <div class="py-4">
            <h4 class="fw-semibold mb-4">File a Request</h4>

            <!-- Form Start -->
            <form id="reportForm" ng-submit="submitRequest()">
              <div class="row">
                <div class="col-12">
                  <div class="mb-3">
                    <label for="categorySelect" class="form-label">Category</label>
                    <select class="form-select" id="categorySelect" ng-model="ri.category" required>
                      <option selected disabled>Select a category</option>
                      <option value="maintenance">MAINTENANCE</option>
                      <option value="security">SECURITY</option>
                      <option value="medical">MEDICAL</option>
                      <option value="utility">UTILITY</option>
                      <!-- <option value="noise">NOISE COMPLAINT</option> -->
                      <option value="others">OTHERS</option>
                    </select>
                  </div>
                </div>

                <div class="col-12">
                  <div class="mb-3">
                    <label for="reportTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="reportTitle" placeholder="Request Title" ng-model="ri.title" required>
                  </div>
                </div>

                <div class="col-12">
                  <div class="mb-3">
                    <label for="reportTitle" class="form-label">Location</label>
                    <input type="text" class="form-control" id="reportTitle" placeholder="Location if applicable" ng-model="ri.location" required>
                  </div>
                </div>

                <div class="col-12">
                  <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Enter description here..."
                      required ng-model="ri.description"></textarea>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-end mt-3">
                  <button type="submit" class="btn btn-secondary">Submit Report</button>
                </div>
              </div>
            </form>
            <!-- Form End -->

          </div>
        </div>


        <div class="tab-pane my-4 fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
          tabindex="0">
          <div class="py-4">
            <h4 class="fw-semibold mb-4">Requests Ticket</h4>
            <div class="table-responsive border mt-3">
                  <table class="table">
                    <thead>
                      <tr>
                        <!-- <th></th> -->
                        <th class="text-secondary" scope="col">ID</th>
                        <th class="text-secondary" scope="col">TITLE</th>
                        <th class="text-secondary" scope="col">STATUS</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="tix in rt" class="align-middle" style="cursor: pointer;" ng-click="openDetails(tix)">
                    <td>{{ tix.id }}</td>

                    <td>
                      <div class="d-flex">
                        <div class="p-2 rounded border">
                          <i class="fa-solid text-secondary fs-4" ng-class="{
                                    'fa-wrench' : tix.category === 'maintenance',
                                    'fa-shield' : tix.category === 'security',
                                    'fa-user-nurse' : tix.category === 'medical',
                                    'fa-broom' : tix.category === 'utility',
                                    'fa-volume-high' : tix.category === 'noise',
                                    'fa-flag' : tix.category === 'others'
                                  }"></i>
                        </div>
                        <div class="ms-2">
                          <span class="fw-semibold">{{ tix.title }}</span>
                          <p class="small text-muted m-0 text-uppercase">{{ tix.category }}</p>
                        </div>
                      </div>
                    </td>

                    <td><span ng-class="{
                                                            'text-success': tix.status == 'Resolved',
                                                            'text-info': tix.status == 'In Progress',
                                                            'text-warning': tix.status == 'New',
                                                            'text-dark': tix.status == 'Closed'
                                                        }"
                        ng-bind="tix.status === 'New' ? 'Pending' : tix.status | uppercase"></span>
                      <!-- {{ tix.status === 'New' ? 'Pending' : tix.status }} -->
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


  <div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <!-- xl for wider modal -->
      <div class="modal-content border-0 shadow-lg rounded-3">
        <div class="modal-header border-0 p-3 border-bottom">
          <!-- <div>
            <h5 class="modal-title fw-bold" ng-bind="selectedItem.title"></h5>
            <small class="text-muted" ng-bind="selectedItem.category | uppercase"></small>
          </div> -->
          <p class="text-uppercase m-0">Request Ticket #{{ selectedItem.id }}</p>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row">

            <!-- LEFT SIDE (Details) -->
            <div class="col-md-7 border-end pe-3">
              <div class="mb-3">
                <h5 class="modal-title fw-bold" ng-bind="selectedItem.title"></h5>
                <small class="text-muted" ng-bind="selectedItem.category | uppercase"></small>
              </div>

              <div class="mb-3">
                <label class="fw-semibold text-uppercase small">Issue Description</label>
                <textarea class="form-control text-dark scarlet-focus mt-2" ng-model="selectedItem.description" rows="4"
                  placeholder="Enter issue description here..." disabled></textarea>
              </div>

              <div class="mb-3">
                <p class="fw-semibold text-uppercase small">Location</p>
                <p><i class="fa-solid fa-map-location-dot text-danger fs-5"></i> {{ selectedItem.location }}</p>
              </div>

              <hr>

              <!-- Priority -->
              <!-- <div class="mb-3">
                <label class="fw-semibold text-uppercase small">Priority</label>
                <div class="dropdown">
                  <span class="badge px-3 py-2 dropdown-toggle" role="button" data-bs-toggle="dropdown" ng-class="{
                                                    'bg-success': selectedItem.priority == 'Low',
                                                    'bg-primary': selectedItem.priority == 'Medium',
                                                    'bg-warning text-dark': selectedItem.priority == 'High',
                                                    'bg-danger': selectedItem.priority == 'Urgent'
                                                }">
                    {{selectedItem.priority}}
                  </span>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.priority='Low'">Low</a></li>
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.priority='Medium'">Medium</a></li>
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.priority='High'">High</a></li>
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.priority='Urgent'">Urgent</a></li>
                  </ul>
                </div>
              </div> -->

              <!-- Status -->
              <div class="mb-3">
                <label class="fw-semibold text-uppercase small">Status</label>
                <div class="dropdown">
                  <span class="badge px-3 py-2 dropdown-toggle" role="button" data-bs-toggle="dropdown" ng-class="{
                                                        'bg-secondary': selectedItem.status == 'New',
                                                        'bg-info text-dark': selectedItem.status == 'In Progress',
                                                        'bg-success': selectedItem.status == 'Resolved',
                                                        'bg-dark': selectedItem.status == 'Closed'
                                                    }">
                    {{ selectedItem.status }}
                  </span>
                  <!-- <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.status='New'">New</a></li>
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.status='In Progress'">In Progress</a>
                    </li>
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.status='Resolved'">Resolved</a></li>
                    <li><a class="dropdown-item" href="#" ng-click="selectedItem.status='Closed'">Closed</a></li>
                  </ul> -->
                </div>
              </div>


              <!-- Requested By -->
              <!-- <div class="mb-3">
                <label class="fw-semibold text-uppercase small">Requested By</label>
                <div class="d-flex align-items-center">
                  <img src="https://ui-avatars.com/api/?name={{selectedItem.requested_by}}&background=random"
                    alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                  <span ng-bind="selectedItem.requested_by"></span>
                </div>
              </div> -->

              <!-- Dates -->
              <div class="row mt-4">
                <div class="col-md-6">
                  <label class="fw-semibold text-uppercase small">Created At</label>
                  <input type="date" class="form-control" ng-model="selectedItem.sysentrydate" disabled>
                </div>

                <div class="col-md-6 mt-3 mt-lg-0">
                  <label class="fw-semibold text-uppercase small">Date Completed</label>
                  <input type="date" class="form-control scarlet-focus" ng-model="selectedItem.resolved_date" disabled>
                </div>
              </div>

            </div>


            <!-- RIGHT SIDE (Comments) -->
            <div class="col-md-5 ps-3 mt-4 mt-md-0"
              style="background: linear-gradient(135deg, #f5f7fa 0%, #e6e9f0 100%); border-left: 1px solid #ddd;">
              <div class="mb-2"></div>
              <h6 class="fw-bold mb-3 mt-2">Comments</h6>

              <!-- Comments List -->
              <div class="comments-box mb-3 p-2" style="max-height: 300px; overflow-y: auto;">
                <div class="mb-2 p-2 shadow-sm" ng-repeat="c in comments">
                  <div class="d-flex">
                    <img src="https://ui-avatars.com/api/?name={{c.modifiedby | uppercase}}&background=random"
                      alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                    <div>

                      <span class="text-uppercase fw-semibold" ng-bind="c.modifiedby"></span>
                      <!-- <span>: &nbsp;</span> -->
                      <div class="text-dark">{{c.description}}</div>


                      <div class="text-dark small text-muted mt-2"> {{c.comment_time}} {{ c.comment_date }} </div>
                    </div>


                  </div>

                </div>
                <!-- If no comments -->
                <div ng-if="!comments || comments.length === 0" class="text-muted small">
                  Be the first one to add a comment</div>
              </div>

              <!-- Comment Input -->
              <form ng-submit="DoPostComment(selectedItem.id)" class="input-group">
                <input type="text" class="form-control scarlet-focus" placeholder="Write a comment..."
                  ng-model="send_comment" required>

                <button class="btn btn-primary" type="submit">Send</button>
              </form>

            </div>

          </div>
        </div>

        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary" ng-click="DoSaveChanges(selectedItem)">Save
            Changes</button> -->
        </div>
      </div>
    </div>
  </div>
  <?php require_once '../framework/Components/mdx_footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

</body>

</html>
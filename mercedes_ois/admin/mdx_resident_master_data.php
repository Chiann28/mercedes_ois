<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resident Master Data MERCEDEX</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
  <script src="../../mercedes_ois/admin/js/ResidentMasterDataController.js"></script>

</head>

<body class="bg-light" ng-controller="ResidentMasterDataController" ng-init="VerifySession()">

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
            Administration • Resident Information • Resident Master Data
          </span>
        </div>

        <div class="row">
          <!-- Master Search -->
          <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-0 rounded-3">
              <div class="card-body">
                <h6 class="card-title fw-semibold">Master Search</h6>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex col-4">
                    <input type="text" class="form-control" placeholder="Search" ng-model="accountnumber">
                    <button class="btn btn-outline-secondary mx-3" type="button" ng-click="openModalSearch()">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>

                  <div class="d-flex gap-3">

                    <button class="btn btn-secondary" type="button" data-bs-toggle="modal"
                      data-bs-target="#newAccountModal">
                      <i class="fa fa-file-excel me-2"></i> Create Account
                    </button>

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
          <div class="col-md-12 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
              <div class="card-body">
                <h6 class="card-title fw-semibold mb-3">Account Details</h6>
                <div class="row mb-3">

                  <div class="col-md-3">
                    <label class="form-label mt-3">Accountnumber</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.accountnumber" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.accountnumber ? customer.accountnumber : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Status</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.status" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.date_registered ? customer.date_registered : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Date Registered</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="date" class="form-control" ng-model="mdx.date_registered" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.date_registered ? customer.date_registered : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Unit Type</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.type" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.firstname ? customer.firstname : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">First Name</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.firstname" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.firstname ? customer.firstname : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Middle Name</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.middlename" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.middlename ? customer.middlename : '---' }}
                      </span> -->
                    </div>
                  </div>


                  <div class="col-md-3">
                    <label class="form-label mt-3">Last Name</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.lastname" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.lastname ? customer.lastname : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Phone Number</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.contact_number" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.contact_number ? customer.contact_number : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Email</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.email" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.email ? customer.email : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Lot Number</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.lot_number" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.lot_number ? customer.lot_number : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">House Number</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.house_no" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.house_no ? customer.house_no : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label mt-3">Full Address</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.address" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.house_no ? customer.house_no : '---' }}
                      </span> -->
                    </div>
                  </div>


                  

                  

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Transactions -->
          <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-0 rounded-3">
              <div class="card-body">
                <h6 class="card-title fw-semibold mb-3">Ledger</h6>

                <!-- Tabs -->
                <ul class="nav nav-tabs" id="transactionTabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark" id="latest-tab" data-bs-toggle="tab"
                      data-bs-target="#latest" type="button" role="tab" aria-controls="latest" aria-selected="true">
                      Transactions
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="history-tab" data-bs-toggle="tab" data-bs-target="#history"
                      type="button" role="tab" aria-controls="history" aria-selected="false">
                      Adjustments
                    </button>
                  </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="transactionTabsContent">
                  <!-- Latest Transactions -->
                  <div class="tab-pane fade show active" id="latest" role="tabpanel" aria-labelledby="latest-tab">
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
                            <td><i class="fa fa-arrow-right text-muted"></i></td>
                            <td>{{t.transaction_id}}</td>
                            <td>{{t.transaction_type}}</td>
                            <td>{{t.amount_paid | number: 2}}</td>
                            <td>{{t.sysentrydate}}</td>
                            <td>{{t.status}}</td>
                          </tr>
                          <tr ng-if="!Transactions || Transactions.length === 0">
                            <td colspan="5" class="text-center text-muted">No transactions
                              found.</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- Full History -->
                  <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover align-middle">
                        <thead class="table-secondary">
                          <th></th>
                          <th>Transaction ID</th>
                          <th>Amount</th>
                          <th>Transaction Date</th>
                          <th>Adjusted By</th>
                        </thead>
                        <tbody>
                          <tr ng-repeat="t in Adjustments" class="animate__animated animate__fadeIn">
                            <td><i class="fa fa-arrow-right text-muted"></i></td>
                            <td>{{t.reference}}</td>
                            <td>{{t.amount | number: 2}}</td>
                            <td>{{t.sysentrydate}}</td>
                            <td>{{t.modifiedby}}</td>
                          </tr>
                          <tr ng-if="!Adjustments || Adjustments.length === 0">
                            <td colspan="5" class="text-center text-muted">No transactions
                              found.</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div> <!-- End Tab Content -->
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- New Account Modal -->
      <div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content rounded-3 shadow">
            <div class="modal-header">
              <h5 class="modal-title" id="formModalLabel">Form Modal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="exampleForm" ng-submit="DoCreateAccount()">
              <div class="modal-body">
                <div class="mb-3">
                  <label for="fullname" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" ng-model="newacc_first_name" required>
                </div>
                <div class="mb-3">
                  <label for="fullname" class="form-label">Middle Name</label>
                  <input type="text" class="form-control" id="middle_name" name="middle_name" ng-model="newacc_middle_name">
                </div>
                <div class="mb-3">
                  <label for="fullname" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="last_name" name="last_name" ng-model="newacc_last_name" required>
                </div>
                <div class="mb-3">
                  <label for="role" class="form-label">Role</label>
                  <select class="form-select" id="role" name="role" ng-model="newacc_role" required>
                    <option value="" selected disabled>Select a role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="text" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" ng-model="newacc_username" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" ng-model="newacc_password" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create Account</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Accounts Modal -->
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
                    <tr ng-repeat="acc in accountlist | filter:accountSearch" class="animate__animated animate__fadeIn">
                      <td>{{acc.accountnumber}}</td>
                      <td>{{acc.firstname}}</td>
                      <td>{{acc.lastname}}</td>
                      <td>{{acc.email}}</td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                          ng-click="GetAccountDetails(acc.accountnumber)" data-bs-dismiss="modal">
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
  </div>

  <!-- bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

  <script src="../framework/JS/jsForStyling.js"></script>

</body>

</html>
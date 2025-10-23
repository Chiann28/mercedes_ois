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

<body class="mdx-body-color" ng-controller="ResidentMasterDataController" ng-init="VerifySession()">

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

        <!-- Master Search -->
        <div class="row">

          <div class="col-md-12 mb-4">
            <div class="border border-dark-subtle rounded p-4 bg-light">

              <h6 class="card-title fw-semibold mb-3">Master Search</h6>
              <div class="row">

                <div class="d-flex col-12 col-lg-6">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" ng-model="accountnumber">
                    <button class="btn btn-outline-secondary" type="button" ng-click="openModalSearch()">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>

                <!-- <div class="col-6 d-flex align-items-center justify-content-end">
                  <button class="btn btn-secondary" type="button" data-bs-toggle="modal"
                    data-bs-target="#newAccountModal">
                    <i class="fa fa-file-excel me-2"></i> Create Account
                  </button>
                </div> -->

              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-12 col-lg-3">
            <div class="col-12">
              <div class="border border-dark-subtle bg-light rounded p-4">
                <div class="col-12 text-center">
                  <div class="bg-secondary mx-auto"
                    style="height: 8rem !important; width: 8rem !important; border-radius: 4rem;"></div>
                </div>
                <div class="col-12 mt-3">

                  <div class="col-12">
                    <label class="form-label mt-3">Full Name</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.fullname" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.accountnumber ? customer.accountnumber : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label mt-3">Accountnumber</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="text" class="form-control" ng-model="mdx.accountnumber" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.accountnumber ? customer.accountnumber : '---' }}
                      </span> -->
                    </div>
                  </div>

                  <div class="col-md-12">
                    <label class="form-label mt-3">Date Registered</label>
                    <div class="col-12 d-flex align-items-center">
                      <input type="date" class="form-control" ng-model="mdx.date_registered" disabled>
                      <!-- <span class="fw-bold">
                        {{ customer.date_registered ? customer.date_registered : '---' }}
                      </span> -->
                    </div>
                  </div>

                </div>
              </div>

            </div>

            <div class="col-12 mt-4 mb-0 mb-md-4">
              <div class="border border-dark-subtle bg-light rounded p-4">
                <div class="w-100 d-flex justify-content-between align-items-center">
                  <div>
                    <p class="m-0 fw-semibold">Banned</p>
                    <p class="m-0">Disable this account</p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" style="width: 3rem !important; height: 1.5rem !important;"
                      type="checkbox" role="switch" id="switchCheckChecked" ng-disabled="!isEditing">
                  </div>
                </div>

                <!-- <div class="mt-3 w-100 d-flex justify-content-between align-items-center">
                  <div>
                    <p class="m-0 fw-semibold">Account Verified</p>
                    <p class="m-0">Disable this account</p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" style="width: 3rem !important; height: 1.5rem !important;"
                      type="checkbox" role="switch" id="switchCheckChecked" ng-disabled="!isEditing">
                  </div>
                </div> -->

              </div>

            </div>

          </div>

          <!-- Account Details-->
          <div class="col-12 col-lg-9 mt-3 mt-md-0">
            <div class="col-12 border border-dark-subtle bg-light rounded p-4">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-3">Overview</h5>
                <button class="btn btn-secondary btn-sm" type="button" ng-click="InitializeUpdating()">
                  <i class="fa-solid fa-xmark" ng-if="isEditing"></i>
                  <i class="fa-solid fa-user-pen" ng-if="!isEditing"></i>

                </button>
              </div>

              <div class="row mb-3">





                <div class="col-md-4">
                  <label class="form-label mt-3">First Name</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.firstname" ng-disabled="!isEditing">
                    <!-- <span class="fw-bold">
                        {{ customer.firstname ? customer.firstname : '---' }}
                      </span> -->
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="form-label mt-3">Middle Name</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.middlename" ng-disabled="!isEditing">
                    <!-- <span class="fw-bold">
                        {{ customer.middlename ? customer.middlename : '---' }}
                      </span> -->
                  </div>
                </div>


                <div class="col-md-4">
                  <label class="form-label mt-3">Last Name</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.lastname" ng-disabled="!isEditing">
                    <!-- <span class="fw-bold">
                        {{ customer.lastname ? customer.lastname : '---' }}
                      </span> -->
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label mt-3">Phone Number</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.contact_number" ng-disabled="!isEditing">
                    <!-- <span class="fw-bold">
                        {{ customer.contact_number ? customer.contact_number : '---' }}
                      </span> -->
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label mt-3">Email</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.email" ng-disabled="!isEditing">
                    <!-- <span class="fw-bold">
                        {{ customer.email ? customer.email : '---' }}
                      </span> -->
                  </div>
                </div>
              </div>



            </div>

            <div class="col-12 border border-dark-subtle bg-light rounded p-4 mt-4">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-3">Account Details</h5>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label mt-3">Status</label>
                  <div class="col-12 d-flex align-items-center">
                    <select class="form-control" ng-model="mdx.status" ng-disabled="!isEditing">
                      <option value=""></option>
                      <option value="ACTIVE">ACTIVE</option>
                      <option value="INACTIVE">INACTIVE</option>
                    </select>
                    <!-- <span class="fw-bold">
                        {{ customer.date_registered ? customer.date_registered : '---' }}
                      </span> -->
                  </div>
                </div>



                <div class="col-md-6">
                  <label class="form-label mt-3">Unit Type</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.type" disabled>
                    <!-- <span class="fw-bold">
                        {{ customer.firstname ? customer.firstname : '---' }}
                      </span> -->
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="form-label mt-3">Lot Number</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.lot_number" disabled>
                    <!-- <span class="fw-bold">
                        {{ customer.lot_number ? customer.lot_number : '---' }}
                      </span> -->
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="form-label mt-3">House Number</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.house_no" disabled>
                    <!-- <span class="fw-bold">
                        {{ customer.house_no ? customer.house_no : '---' }}
                      </span> -->
                  </div>
                </div>

                <div class="col-md-4">
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

          <div class="col-12">
            <div class="border border-dark-subtle bg-light rounded p-4 mt-2">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-3">Property Details</h5>
              </div>

              <div class="row mb-3">
                <div class="col-md-3">
                  <label class="form-label mt-3">Property Code</label>
                  <div class="input-group">
                    <input type="text" class="form-control" ng-model="mdx.property_code" ng-disabled="!isEditing">
                    <button class="btn btn-outline-secondary" type="button" ng-click="openPropModal()" ng-disabled="!isEditing">
                      <i class="fa fa-solid fa-pencil"></i>
                    </button>
                  </div>
                </div>



                <div class="col-md-9">
                  <label class="form-label mt-3">Property Name</label>
                  <div class="col-12 d-flex align-items-center">
                    <input type="text" class="form-control" ng-model="mdx.property_name" disabled>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12" ng-show="isEditing">
            <div class="border border-dark-subtle bg-light rounded p-4 mt-4">
              <div class="d-flex gap-3 justify-content-end">
                <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash-can small"></i>
                  Discard</button>
                <button type="button" class="btn btn-success" ng-click="DoUpdateAccount()">Update</button>
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
                  <input type="text" class="form-control" id="first_name" name="first_name" ng-model="newacc_first_name"
                    required>
                </div>
                <div class="mb-3">
                  <label for="fullname" class="form-label">Middle Name</label>
                  <input type="text" class="form-control" id="middle_name" name="middle_name"
                    ng-model="newacc_middle_name">
                </div>
                <div class="mb-3">
                  <label for="fullname" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="last_name" name="last_name" ng-model="newacc_last_name"
                    required>
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
                  <input type="text" class="form-control" id="username" name="username" ng-model="newacc_username"
                    required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" ng-model="newacc_password"
                    required>
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


      <!-- Prop Modal -->
       <div class="modal fade" id="propModal" tabindex="-1" aria-labelledby="propModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content shadow-lg border-0 rounded-4">

            <!-- Header -->
            <div class="modal-header bg-secondary text-white rounded-top-4">
              <h5 class="modal-title fw-semibold" id="accountSearchLabel">
                <i class="fa-solid fa-users me-2"></i> Select Property
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
                  placeholder="Search by property code">
              </div>

              <!-- Account Table -->
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-primary text-dark">
                    <tr>
                      <th>Code</th>
                      <th>Unit Name</th>
                      <th>Unit Type</th>
                      <th>Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="p in proplist | filter:accountSearch" class="animate__animated animate__fadeIn">
                      <td>{{p.property_code}}</td>
                      <td>{{p.property_name}}</td>
                      <td>{{p.property_type}}</td>
                      <td>{{p.property_status}}</td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                          ng-click="GetPropertyDetails(p.property_code)" data-bs-dismiss="modal">
                          <i class="fa-solid fa-check me-1"></i> Select
                        </button>
                      </td>
                    </tr>
                    <tr ng-if="!proplist || proplist.length === 0">
                      <td colspan="4" class="text-center text-muted py-3">
                        <i class="fa-regular fa-circle-xmark me-2"></i> No property found.
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
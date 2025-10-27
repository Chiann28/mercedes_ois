<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration MERCEDEX</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
  <script src="../../mercedes_ois/admin/js/NewApplicationController.js"></script>

</head>

<body class="mdx-body-color" ng-controller="NewApplicationController" ng-init="VerifySession()">

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
            Administration • Admin Registration
          </span>
        </div>

        <!-- Master Search -->
        <div class="row">

          <div class="col-md-12 mb-4">
            <div class="border border-dark-subtle rounded p-4 bg-light">

              <h5 class="card-title fw-semibold mb-0">Admin Registration</h5>
              <!-- <div class="row">

                <div class="d-flex col-12 col-lg-6">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" ng-model="accountnumber">
                    <button class="btn btn-outline-secondary" type="button" ng-click="openModalSearch()">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>


              </div> -->
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-12">
            <div class="border border-dark-subtle rounded p-4 bg-light">
              <form id="createAccountForm" name="createAccountForm" ng-submit="DoCreateAdmin(createAccountForm)" novalidate>
  <div class="row mb-3">
    <div class="col-md-6 mb-3">
      <label for="firstName" class="form-label fw-semibold">First Name</label>
      <input type="text" class="form-control" id="firstName"
             ng-model="adminreq.firstname" placeholder="Enter first name" required>
    </div>
    <div class="col-md-6 mb-3">
      <label for="lastName" class="form-label fw-semibold">Last Name</label>
      <input type="text" class="form-control" id="lastName"
             ng-model="adminreq.lastname" placeholder="Enter last name" required>
    </div>

    <div class="col-md-6 mb-3">
      <label for="username" class="form-label fw-semibold">Username</label>
      <input type="text" class="form-control" id="username"
             ng-model="adminreq.username" placeholder="Enter username" required>
    </div>

    <div class="col-md-6 mb-3">
      <label for="password" class="form-label fw-semibold">Password</label>
      <div class="input-group">
        <input type="password" class="form-control" id="password"
               ng-model="adminreq.password" placeholder="Enter password" required>
        <span class="input-group-text bg-white">
          <i class="fa-regular fa-eye text-secondary" id="togglePassword" style="cursor: pointer;"></i>
        </span>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-lg-end">
    <button type="submit" class="btn btn-secondary">Create Admin Account</button>
  </div>
</form>

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
  <script>
    // Show/Hide password toggle
    document.getElementById("togglePassword").addEventListener("click", function () {
      const passwordInput = document.getElementById("password");
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });
  </script>

</body>

</html>
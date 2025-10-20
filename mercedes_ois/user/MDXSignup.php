<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MERCEDEX</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- NASHIE_CSS -->
  <link rel="stylesheet" href="../framework/css/NashieCss.css">
  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
  <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- JAVASCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
  <script src="../../mercedes_ois/user/js/LoginController.js"></script>

</head>

<body class="bg-light" ng-controller="LoginController" ng-init="">
  <!-- Header -->
  <nav class="navbar navbar-expand-lg bg-none">
    <div class="container">

      <!-- <a class="navbar-brand text-light" href="#">LOGO</a> -->
      <a class="navbar-brand d-flex align-items-center" href="#" class="text-light">
        <img src="..\admin\logo_mercedes.png" alt="" style="height: 45px;">
        <span class="fw-bold h3 mb-0" style="color: #fe3131;">MERCEDES</span>
      </a>
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <!-- <li class="nav-item">
                        <a class="nav-link text-light mdx-text-hover" href="#">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mdx-text-hover" href="#">About Us</a>
                    </li> -->
          <!-- <li class="nav-item">
                        <a class="nav-link text-light mdx-text-hover" href="MDXSignup.php">Sign up</a>
                    </li> -->
          <li class="nav-item">
            <a class="nav-link text-dark mdx-text-hover" href="MDXLogin.php" style="cursor: pointer;">Login</a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Categories</a></li>
              <li><a class="dropdown-item" href="#">About Us</a></li>
              <li><a class="dropdown-item" href="#">Help</a></li>
              <li><a class="dropdown-item" href="#">Login</a></li>
            </ul>
          </li> -->
        </ul>
      </div>
    </div>
  </nav>

<form name="accountRequestForm" ng-submit="DoAccountRequest(accountRequestForm)" novalidate>
  <div class="container mt-5">

    <!-- Section 1: Overview -->
    <div class="col-12 border p-3 my-3 rounded shadow">
      <p class="h3 fw-light">1. Overview</p>
      <div class="row mt-3">

        <div class="col-12 col-md-6 my-2">
          <label for="firstname"><span class="text-muted">First Name</span></label>
          <input type="text" class="form-control mt-2" id="firstname" placeholder="First Name"
            ng-model="accreq.firstname" required>
        </div>

        <div class="col-12 col-md-6 my-2">
          <label for="lastname"><span class="text-muted">Last Name</span></label>
          <input type="text" class="form-control mt-2" id="lastname" placeholder="Last Name"
            ng-model="accreq.lastname" required>
        </div>

        <div class="col-12 my-2">
          <label for="email"><span class="text-muted">Email</span></label>
          <input type="email" class="form-control mt-2" id="email" placeholder="Email"
            ng-model="accreq.email" required>
        </div>

        <div class="col-12 col-md-6 my-2">
          <label for="phone"><span class="text-muted">Mobile Number</span></label>
          <input id="phone" type="tel" class="form-control mt-2" placeholder="09xxxxxxxxx"
            ng-model="accreq.mobile_no" required>
        </div>

        <div class="col-12 col-md-6 my-2">
          <label for="telephone"><span class="text-muted">Telephone</span></label>
          <input type="number" class="form-control mt-2" id="telephone" placeholder="Telephone Number"
            ng-model="accreq.tel_no" required>
        </div>

      </div>
    </div>

    <!-- Section 2: Account Information -->
    <div class="col-12 border p-3 my-3 rounded shadow">
      <p class="h3 fw-light">2. Account Information</p>
      <div class="row mt-3">

        <div class="col-12 my-2">
          <label for="username"><span class="text-muted">Username</span></label>
          <input type="text" class="form-control mt-2" id="username" placeholder="Username"
            ng-model="accreq.username" required>
        </div>

        <div class="col-12 col-md-6 my-2">
          <label for="ref_name"><span class="text-muted">Reference Name</span></label>
          <input type="text" class="form-control mt-2" id="ref_name" placeholder="Reference Name"
            ng-model="accreq.ref_name" required>
        </div>

        <div class="col-12 col-md-6 my-2">
          <label for="ref_contact"><span class="text-muted">Reference Contact No.</span></label>
          <input type="text" class="form-control mt-2" id="ref_contact" placeholder="Reference Contact"
            ng-model="accreq.ref_contact" required>
        </div>

        <div class="col-12 my-2">
          <label for="unittype"><span class="text-muted">Unit Type</span></label>
          <input type="text" class="form-control mt-2" id="unittype" placeholder=""
            ng-model="accreq.unittype" required>
        </div>

        <div class="col-12 col-md-6 my-2">
          <label for="lot_no"><span class="text-muted">Lot No.</span></label>
          <input type="text" class="form-control mt-2" id="lot_no" placeholder=""
            ng-model="accreq.lot_no" required>
        </div>

        <div class="col-12 col-md-6 my-2">
          <label for="house_no"><span class="text-muted">House No.</span></label>
          <input type="text" class="form-control mt-2" id="house_no" placeholder=""
            ng-model="accreq.house_no" required>
        </div>

      </div>
    </div>

    <!-- Submit Button -->
    <div class="col-12 border p-3 my-3 rounded shadow">
      <div class="bg-light">
        <div class="d-flex gap-3 justify-content-end">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </div>
    </div>

  </div>
</form>









  <!-- bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

</body>

</html>
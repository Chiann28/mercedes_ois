<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Application MERCEDEX</title>

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

<body class="bg-light" ng-controller="NewApplicationController" ng-init="VerifySession()">

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
            Administration • Resident Information • New Appliaction
          </span>
        </div>

        <div>
          <form class="col-3" ng-submit="DoCreateAccount()">
            <div class="">
              <label for="inputPassword2" class="">First Name</label>
              <input type="text" class="form-control" id="" placeholder="first name" ng-model="first_name">
            </div>

            <div class="">
              <label for="inputPassword2" class="">Last Name</label>
              <input type="text" class="form-control" id="" placeholder="last name" ng-model="last_name">
            </div>

            <div class="">
              <label for="inputPassword2" class="">Role</label>
              <input type="text" class="form-control" id="" placeholder="role" ng-model="role">
            </div>

            <div class="">
              <label for="" class="">Username</label>
              <input type="text" class="form-control" id="" placeholder="username" ng-model="username">
            </div>

            <div class="">
              <label for="inputPassword2" class="">Password</label>
              <input type="text" class="form-control" id="" placeholder="password" ng-model="password">
            </div>

            <div class="">
              <button type="submit" class="btn btn-primary mb-3">Confirm</button>
            </div>
          </form>
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
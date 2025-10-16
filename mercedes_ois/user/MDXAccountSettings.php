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

  <script src="../../mercedes_ois/user/js/AccountSettingsController.js"></script>


  <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss-Frontend.css">
  <link rel="stylesheet" href="../framework/CSS/user_dashboard_anims.css">
</head>

<body class="bg-light" style="" ng-controller="AccountSettingsController" ng-init="init();">
  <?php require_once '../framework/Components/mdx_user_header.php'; ?>

  <div class="container-md mb-3 py-5" style="min-height: 87vh">
    <div class="p-5 mt-3 shadow-sm rounded border d-flex justify-content-between align-items-center">
      <h1 class="fw-semiboold"><i class="fa-solid fa-gear lower-card-icon-rotate me-1"></i>Profile</h1>
      <div>
        <button class="btn btn-secondary btn-sm" type="button" ng-click="InitializeUpdating()">
          <i class="fa-solid fa-xmark" ng-if="isEditing"></i>
          <i class="fa-solid fa-user-pen" ng-if="!isEditing"></i>

        </button>
      </div>

    </div>

    <div class="row">

      <div class="col-12">
        <div class="p-5 mt-3 shadow-sm rounded border">
          <h4 class="fw-semiboold">Overview</h4>
          <div class="col-12 mt-4">
            <div class="col-12 mb-3">
              <label for="" class="form-label">Accountnumber</label>
              <input type="text" class="form-control" id="" placeholder="" ng-model="data.accountnumber" disabled>
            </div>
            <div class="row">
              <div class="col-12 col-lg-4 mb-3">
                <label for="" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.firstname" ng-disabled="!isEditing">
              </div>
              <div class="col-12 col-lg-4 mb-3">
                <label for="" class="form-label">Middlename</label>
                <input type="text" class="form-control" id="" placeholder=""ng-model="data.middlename" ng-disabled="!isEditing">
              </div>
              <div class="col-12 col-lg-4 mb-3">
                <label for="" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.lastname" ng-disabled="!isEditing">
              </div>
            </div>
          </div>
        </div>

        <div class="p-5 mt-3 shadow-sm rounded border">
          <h4 class="fw-semiboold">Contact details</h4>
          <div class="col-12 mt-4">

            <div class="row">
              <div class="col-6 mb-3">
                <label for="" class="form-label">Email</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.email" ng-disabled="!isEditing">
              </div>
              <div class="col-6 mb-3">
                <label for="" class="form-label">Contact No.</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.contact_number" ng-disabled="!isEditing">
              </div>
            </div>

          </div>
        </div>

        <div class="p-5 mt-3 shadow-sm rounded border">
          <h4 class="fw-semiboold">Property</h4>
          <div class="col-12 mt-4">

            <div class="row">
              <div class="col-6 mb-3">
                <label for="" class="form-label">Address</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.address" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="" class="form-label">Unit Type</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.type" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="" class="form-label">Lot No.</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.lot_number" disabled>
              </div>
              <div class="col-6 mb-3">
                <label for="" class="form-label">House No.</label>
                <input type="text" class="form-control" id="" placeholder="" ng-model="data.house_no" disabled>
              </div>
            </div>

          </div>
        </div>

        <div class="p-5 py-3 mt-3 shadow-sm rounded border" ng-hide="!isEditing">
          <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-secondary btn-lg" ng-click="UpdateAccount()">Submit</button>


          </div>
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
<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Property MERCEDEX</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">



  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
  <script src="../../mercedes_ois/admin/js/PropertiesController.js"></script>

  <!-- INTTELINPUT -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.8.3/build/css/intlTelInput.css">

  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss.css">


</head>

<body class="mdx-body-color" ng-controller="PropertiesController" ng-init="">

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
            Administration • Properties • New Property
          </span>
        </div>

        <div class="row">

          <!-- <div class="col-12 mt-4">
            <div class="p-4 bg-light rounded border border-dark-subtle">
            

            </div>
          </div> -->




          <!-- overview -->
          <div class="col-12 mt-4">
            <form ng-submit="DoCreateProperty()" class="p-4 bg-light rounded border border-dark-subtle">
              <h4 class="mb-4 text-muted">Add Property</h4>

              <div class="row">
                <div class="col-12 col-md-6 my-2">
                  <label for="propertyCode" class="text-muted">Code</label>
                  <input type="text" class="form-control mt-2" id="propertyCode" placeholder="Enter unit code"
                    ng-model="new_prop.property_code" required>
                </div>

                <div class="col-12 col-md-6 my-2">
                  <label for="propertyType" class="text-muted">Type</label>
                  <select class="form-select mt-2" id="propertyType" ng-model="new_prop.property_type" required>
                    <option value="" disabled selected>Select property type</option>
                    <option value="Residential">Residential</option>
                    <option value="Commercial">Commercial</option>
                  </select>
                </div>


                <div class="col-12 my-2">
                  <label for="unitName" class="text-muted">Unit Name</label>
                  <input type="text" class="form-control mt-2" id="unitName" placeholder="Enter unit name"
                    ng-model="new_prop.property_name" required>
                </div>

                <div class="col-12 my-2">
                  <label for="unitName" class="text-muted">Location</label>
                  <input type="text" class="form-control mt-2" id="unitName" placeholder="Enter unit location"
                    ng-model="new_prop.location" required>
                </div>

                <div class="col-12 col-md-4 my-2">
                  <label for="blockNo" class="text-muted">Block No.</label>
                  <input type="text" class="form-control mt-2" id="blockNo" placeholder="Enter block no."
                    ng-model="new_prop.block_no">
                </div>

                <div class="col-12 col-md-4 my-2">
                  <label for="houseNo" class="text-muted">House No.</label>
                  <input type="text" class="form-control mt-2" id="houseNo" placeholder="Enter house no."
                    ng-model="new_prop.house_no">
                </div>

                <div class="col-12 col-md-4 my-2">
                  <label for="lotNo" class="text-muted">Lot No.</label>
                  <input type="text" class="form-control mt-2" id="lotNo" placeholder="Enter lot no."
                    ng-model="new_prop.lot_no">
                </div>
              </div>

              <div class="col-12 my-2">
                  <label for="unitName" class="text-muted">Unit Monthly Rate</label>
                  <input type="number" class="form-control mt-2" id="unitName" placeholder="Enter unit rate"
                    ng-model="new_prop.price" required>
                </div>

              <!-- Submit Button (lower right) -->
              <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-secondary px-4">
                  <i class="fa fa-save me-2"></i> Submit
                </button>
              </div>
            </form>
          </div>






        </div>




      </div>

    </div>




  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.8.3/build/js/intlTelInput.min.js"></script>
  <script>

    const input = document.querySelector("#phone");
    window.intlTelInput(input, {
      initialCountry: "ph",
      onlyCountries: ["ph",],
      separateDialCode: true,
      loadUtils: () => import("/intl-tel-input/js/utils.js?1756816377902") // for formatting/placeholders etc
    });
    const input2 = document.querySelector("#phone2");
    window.intlTelInput(input2, {
      initialCountry: "ph",
      onlyCountries: ["ph",],
      separateDialCode: true,
      loadUtils: () => import("/intl-tel-input/js/utils.js?1756816377902") // for formatting/placeholders etc
    });
  </script>

  <!-- bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

  <script src="../framework/JS/jsForStyling.js"></script>



</body>

</html>
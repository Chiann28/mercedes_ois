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



  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
  <script src="../../mercedes_ois/admin/js/NewApplicationController.js"></script>

  <!-- INTTELINPUT -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.8.3/build/css/intlTelInput.css">

  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss.css">


</head>

<body class="mdx-body-color" ng-controller="NewApplicationController" ng-init="VerifySession(); GetAccountRequest()">

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
            Administration • Resident Information • New Application
          </span>
        </div>

        <div class="row">

          <div class="col-12 col-lg-3">

            <div class="p-4 bg-light rounded border border-dark-subtle" style="min-height: 70vh !important;">
              <h4 class="mb-3 text-muted">Requests</h4>
              <div class="border border-dark-subtle"></div>
              <div class="d-flex justify-content-end mb-3 mt-3">
                <input type="text" class="form-control w-100 w-md-50" placeholder="Search..." />
              </div>
              <table class="table table-hover mt-3 border rounded col-12">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <!-- <th scope="col">Date</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="req in request_list">
                    <td style="cursor: pointer;">
                      <a ng-click="PopulateNewAppTable(req)">
                        <i class="fa fa-arrow-right text-muted"></i>
                      </a>
                    </td>
                    <td>{{ req.request_id }}</td>
                    <td>{{ req.fullname }}</td>

                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-12 col-lg-9 mt-4 mt-md-0">
            <div class="row">



              <!-- overview -->
              <div class="col-12 col-md-6 col-lg-8 mt-4 mt-lg-0">
                <div class="p-4 bg-light rounded border border-dark-subtle">

                  <h4 class="mb-4 text-muted">Overview</h4>
                  <div class="row">

                    <div class="col-12 col-md-6 my-2">
                      <label for="firstname"><span class="text-muted">First Name</span></label>
                      <input type="text" class="form-control mt-2" id="firstname" placeholder="First Name"
                        ng-model="newapp.firstname">
                    </div>

                    <div class="col-12 col-md-6 my-2">
                      <label for="lastname"><span class="text-muted">Last Name</span></label>
                      <input type="text" class="form-control mt-2" id="firstname" placeholder="Last Name"
                        ng-model="newapp.lastname">
                    </div>

                    <div class="col-12 my-2">
                      <label for="email"><span class="text-muted">Email</span></label>
                      <input type="email" class="form-control mt-2" id="email" placeholder="Email"
                        ng-model="newapp.email">
                    </div>

                    <div class="col-12 col-md-6 my-2">
                      <label for="phone"><span class="text-muted">Mobile Number</span></label>
                      <div class="mt-2">
                        <input id="phone" type="tel" placeholder="" class="form-control" ng-model="newapp.mobile_no">
                      </div>
                    </div>

                    <div class="col-12 col-md-6 my-2">
                      <label for="telephone"><span class="text-muted">Telephone</span></label>
                      <input type="number" class="form-control mt-2" id="telephone" placeholder=""
                        ng-model="newapp.tel_no">
                    </div>




                  </div>

                </div>
              </div>


              <!-- account information -->
              <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                <div class="p-4 bg-light rounded border border-dark-subtle">
                  <h4 class="mb-4 text-muted">Account Information</h4>
                  <div class="row gap-4">
                    <div class="col-12">
                      <label for="accountnumber"><span class="text-muted">Accountnumber</span></label>
                      <div class="input-group mt-2">
                        <input type="text" class="form-control" id="accountnumber" placeholder="" disabled
                          ng-model="newapp.accountnumber">
                        <button class="btn btn-sm btn-outline-secondary" type="button"
                          ng-click="DoGenerateAccountNumber()">
                          <i class="fa-solid fa-user-gear"></i>
                        </button>
                      </div>
                    </div>


                    <div class="col-12">
                      <label for="username"><span class="text-muted">Username</span></label>
                      <input type="text" class="form-control mt-2" id="username" placeholder="Username"
                        ng-model="newapp.username">
                    </div>
                    <div class="col-12">
                      <label for="password"><span class="text-muted">One Time Password</span></label>
                      <!-- <input type="text" class="form-control mt-2" id="password" placeholder="Password"
                        ng-model="newapp.password"> -->
                      <div class="input-group mt-2">
                        <input type="text" class="form-control" id="password" placeholder="" ng-model="newapp.password">
                        <button class="btn btn-sm btn-outline-secondary" type="button" ng-click="DoGeneratePassword()">
                          <i class="fa-solid fa-key"></i>
                        </button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>


              <!-- additional info -->
              <div class="col-12 col-lg-6 mt-4">
                <div class="p-4 bg-light rounded border border-dark-subtle">

                  <h4 class="mb-4 text-muted">Additional Information</h4>
                  <div class="row">

                    <div class="col-12 my-2">
                      <label for="unittype"><span class="text-muted">Unit Type</span></label>
                      <input type="text" class="form-control mt-2" id="unittype" placeholder=""
                        ng-model="newapp.unittype">
                    </div>

                    <div class="col-12 col-md-6 my-2">
                      <label for="lot_no"><span class="text-muted">Lot No.</span></label>
                      <input type="text" class="form-control mt-2" id="lot_no" placeholder="" ng-model="newapp.lot_no">
                    </div>

                    <div class="col-12 col-md-6 my-2">
                      <label for="houseNo"><span class="text-muted">House No.</span></label>
                      <input type="text" class="form-control mt-2" id="houseNo" placeholder=""
                        ng-model="newapp.house_no">
                    </div>



                  </div>

                </div>
              </div>


              <!-- reference  -->
              <div class="col-12 col-lg-6 mt-4">
                <div class="p-4 bg-light rounded border border-dark-subtle h-100">

                  <h4 class="mb-4 text-muted">Reference</h4>
                  <div class="row">

                    <div class="col-12 col-md-6 my-2">
                      <label for="refFullname"><span class="text-muted">Full Name</span></label>
                      <input type="text" class="form-control mt-2" id="refFullname" placeholder="Reference Full Name"
                        ng-model="newapp.ref_fullname">
                    </div>

                    <div class="col-12 col-md-6 my-2">
                      <label for="phone2"><span class="text-muted">Mobile Number</span></label>
                      <div class="mt-2">
                        <input id="phone2" type="tel" placeholder="" class="form-control"
                          ng-model="newapp.ref_mobile_no">
                      </div>
                    </div>

                    <div class="col-12 my-2">
                      <label for="relationship"><span class="text-muted">Relationship</span></label>
                      <input type="text" class="form-control mt-2" id="relationship" placeholder="Relationship"
                        ng-model="newapp.ref_rel">
                    </div>


                  </div>

                </div>
              </div>


              <!-- submit -->
              <div class="col-12 mt-4">
                <div class="p-4 bg-light rounded border border-dark-subtle">

                  <div class="d-flex gap-3 justify-content-end">
                    <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash-can small"></i>
                      Discard</button>
                    <button type="button" class="btn btn-success" ng-click="DoCreateAccount()">Create</button>
                  </div>



                </div>
              </div>
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
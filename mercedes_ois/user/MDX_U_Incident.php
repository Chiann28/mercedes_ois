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

<body class="bg-light" style="" ng-controller="U_IncidentAndRequestController" ng-init="init();">
  <?php require_once '../framework/Components/mdx_user_header.php'; ?>

  <div class="container-md mb-3 py-5" style="min-height: 87vh">
    <div class="p-5 mt-3 shadow-sm rounded border d-flex justify-content-between align-items-center">
      <h1 class="fw-semiboold"><i class="fa-solid fa-triangle-exclamation lower-card-icon-rotate me-1"></i>Report
        Incident</h1>
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
            File a Report
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
            <h4 class="fw-semibold mb-4">File a Report</h4>

            <!-- Form Start -->
            <form id="reportForm" ng-submit="submitReport()">
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
                      <option value="noise">NOISE COMPLAINT</option>
                      <option value="others">OTHERS</option>
                    </select>
                  </div>
                </div>

                <div class="col-12">
                  <div class="mb-3">
                    <label for="reportTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="reportTitle" placeholder="Incident title" ng-model="ri.title" required>
                  </div>
                </div>

                <div class="col-12">
                  <div class="mb-3">
                    <label for="reportTitle" class="form-label">Location</label>
                    <input type="text" class="form-control" id="reportTitle" placeholder="Incident Location" ng-model="ri.location" required>
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
            <h4 class="fw-semibold mb-4">Reports Ticket</h4>
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
                      <tr ng-repeat="tix in rt" class="align-middle">
                        <td>{{ tix.id }}</td>

                        <td>{{ tix.title }}</td>

                        
                        <td>{{ tix.status === 'New' ? 'Pending' : tix.status }}</td>
                      </tr>

                    </tbody>
                  </table>
                </div>
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
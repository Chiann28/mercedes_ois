<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events MERCEDEX</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">



  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
  <script src="../../mercedes_ois/admin/js/EventsController.js"></script>

  <!-- INTTELINPUT -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.8.3/build/css/intlTelInput.css">

  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss.css">


</head>

<body class="mdx-body-color" ng-controller="EventsController" ng-init="VerifySession(); GetEvents();">

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
            Administration • Resident Information • Events And Operations
          </span>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="col-6 bg-light p-3 rounded">
              <form ng-submit="DoPostEvent()">
                <div class="mb-3">
                  <label for="" class="form-label">Event Type</label>
                  <input type="text" class="form-control" id="" name="email" placeholder="" required ng-model="postevent.event_type">
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">Title</label>
                  <input type="text" class="form-control" id="" name="email" placeholder="" required ng-model="postevent.event_name">
                </div>

                <div class="row">
                  <div class="col-6">
                    <div class="mb-3">
                      <label for="eventDateTime" class="form-label">From</label>
                      <input type="datetime-local" class="form-control" id="eventDateTime" name="eventDateTime"
                        required ng-model="postevent.start_date">
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="mb-3">
                      <label for="eventDateTime" class="form-label">To</label>
                      <input type="datetime-local" class="form-control" id="eventDateTime" name="eventDateTime"
                        required ng-model="postevent.end_date">
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">Details</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3"
                    required ng-model="postevent.event_description"></textarea>
                </div>

                <div class="mb-3">
                  <label for="" class="form-label">Location</label>
                  <input type="text" class="form-control" id="" name="email" placeholder="" required ng-model="postevent.location">
                </div>

                



                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>


          </div>
          <div class="col-12 mt-4">
            <div class="row">

              <div class="row">
                <div class="col-md-4" ng-repeat="event in EventsList">
                  <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                      <h4 class="card-title">{{ event.event_name }}</h4>
                      <p class="card-text">{{ event.event_description }}</p>
                      <p> {{ event.date_start }}</p>
                      <p> {{ event.start_time }} - {{ event.end_time }}</p>
                      <p> </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary">View</button>
                        <p class="m-0 text-muted">Event No: {{ event.event_no }}</p>
                      </div>

                    </div>
                  </div>
                </div>

              </div>




            </div>
          </div>
        </div>



      </div>




    </div>
  </div>

  <!-- <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.8.3/build/js/intlTelInput.min.js"></script>
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
  </script> -->

  <!-- bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

  <script src="../framework/JS/jsForStyling.js"></script>



</body>

</html>
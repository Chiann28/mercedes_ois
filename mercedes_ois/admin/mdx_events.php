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

  <style>
    .nav-link.active {
      background-color: #f55355 !important;
      /* your highlight color */
      color: #fff !important;
      /* make text white */
      border-radius: 8px;
      /* optional */
    }
  </style>


</head>

<body class="mdx-body-color" ng-controller="EventsController" ng-init="VerifySession(); initRequest();">

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
          <!-- togglers -->
          <div class="col-12">
            <div class="col-12 p-4 bg-light rounded border border-dark-subtle mb-4">

              <div class="row" id="myTab" role="tablist">
                <!-- Upcoming Events -->
                <div class="col-md-4 mt-3 mt-lg-0">
                  <div class="p-3 bg-light border rounded nav-link active" id="tab1-tab" data-bs-toggle="tab"
                    data-bs-target="#tab1" role="tab" style="cursor: pointer; min-height: 15vh;">

                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <p class="m-0 fs-1">{{ EventCount || '0' }}</p>
                      <div class="" style="border-radius: 50%">
                        <i class="fa-regular fa-clock display-3" style="opacity: 25%;"></i>
                      </div>
                    </div>
                    <p class="m-0 fs-5 fw-light">Upcoming Events</p>
                    <p class="small mb-0 mt-1 fw-light"><span class="mdx-text-yellow">0</span> This Week </p>



                  </div>
                </div>

                <!-- Past Events -->
                <div class="col-md-4 mt-3 mt-lg-0">
                  <div class="p-3 bg-light border rounded nav-link" id="tab2-tab" data-bs-toggle="tab"
                    data-bs-target="#tab2" role="tab" style="cursor: pointer; min-height: 15vh;">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <p class="m-0 fs-1">{{ PastEventCount || '0' }}</p>
                      <div class="" style="border-radius: 50%">
                        <i class="fa-regular fa-calendar-check display-3" style="opacity: 25%;"></i>
                      </div>
                    </div>


                    <p class="fw-light m-0 fs-5">Past Events</p>
                    <p class="small mb-0 mt-1 fw-light"><span class="mdx-text-green">0</span> This Week </p>
                  </div>
                </div>

                <!-- Create Event -->
                <div class="col-md-4 mt-3 mt-lg-0">
                  <div class="p-3 bg-light border rounded nav-link" id="tab3-tab" data-bs-toggle="tab"
                    data-bs-target="#tab3" role="tab" style="cursor: pointer; height: 100%;">

                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <p class="m-0 fs-1">Add event</p>
                      <div class="" style="border-radius: 50%">
                        <i class="fa-regular fa-calendar-plus display-3" style="opacity: 25%;"></i>
                      </div>
                    </div>


                    <p class="fw-light m-0 fs-5 text-light"><br></p>
                    <p class="small mb-0 mt-1 fw-light"><span class="mdx-text-green">24</span> Events created today </p>
                  </div>
                </div>
              </div>

            </div>



          </div>

          <div class="col-12">
            <div class="bg-light tab-content border border-dark-subtle rounded mt-3 p-3" id="myTabContent">

              <!-- upcoming events -->
              <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                <div class="col-12 mt-3">
                  <div class="row">


                    <div class="col-12 col-md-6 col-lg-4" ng-repeat="event in EventsList">
                      <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <div>
                              <h4 class="card-title">{{ event.event_name }}</h4>
                              <p class="card-text">{{ event.event_description }}</p>
                              <p> {{ event.date_start }}</p>
                              <p> {{ event.start_time }} - {{ event.end_time }}</p>
                              <p> </p>
                            </div>
                            <div>
                              <i class="fa-solid display-5" ng-class="{ 'fa-leaf mdx-text-green' : event.event_type === 'ENVIRONMENTAL',
                              'fa-cake-candles mdx-text-pink' : event.event_type === 'BIRTHDAY',
                              'fa-dove text-secondary' : event.event_type === 'FUNERAL',
                              'fa-comments mdx-text-blue' : event.event_type === 'SEMINAR',
                              'fa-champagne-glasses mdx-text-yellow' : event.event_type === 'CELEBRATION',
                              }"></i>
                            </div>
                          </div>

                          <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                              data-bs-target="#eventDetailsModal" ng-click="setSelectedEvent(event)"><i
                                class="fa-regular fa-eye"></i></button>
                            <p class="m-0 text-muted">Event No: {{ event.event_no }}</p>
                          </div>

                        </div>
                      </div>
                    </div>






                  </div>
                </div>
              </div>

              <!-- past events -->
              <div class="tab-pane fade" id="tab2" role="tabpanel">
                <div class="table-responsive border">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th scope="col">Event No</th>
                        <th scope="col">Title</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="past in pastEvents">
                        <td style="cursor: pointer;">
                          <a ng-click="">
                            <i class="fa fa-arrow-right text-muted"></i>
                          </a>
                        </td>
                        <td>{{ past.event_no }}</td>
                        <td>{{ past.event_name }}</td>
                        <td>{{ past.start_date }}</td>
                        <td>{{ past.end_date }}</td>
                        <td> . </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>

              <!-- create -->
              <div class="tab-pane fade" id="tab3" role="tabpanel">
                <div class="col-12 bg-light rounded">
                  <form ng-submit="DoPostEvent()">
                    <div class="mb-3">
                      <label for="eventType" class="form-label">Event Type</label>
                      <select class="form-select" id="eventType" name="event_type" ng-model="postevent.event_type"
                        required>
                        <option value="" disabled selected>Select an event type</option>
                        <option value="Celebration">Celebration</option>
                        <option value="Birthday">Birthday</option>
                        <option value="Seminar">Seminar</option>
                        <option value="Environmental">Environmental</option>
                        <option value="Funeral">Funeral / Burial</option>
                      </select>

                    </div>




                    <div class="mb-3">
                      <label for="" class="form-label">Title</label>
                      <input type="text" class="form-control" id="" name="email" placeholder="" required
                        ng-model="postevent.event_name">
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
                      <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3" required
                        ng-model="postevent.event_description"></textarea>
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Location</label>
                      <input type="text" class="form-control" id="" name="email" placeholder="" required
                        ng-model="postevent.location">
                    </div>




                    <div class="col-12 text-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>






        </div>



      </div>




    </div>
  </div>

  <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h1 class="modal-title fs-5"> {{selectedEvent.event_no}} - {{ selectedEvent.event_name }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3 col-12">
            <label for="eventType" class="form-label">Event Type</label>

            <select class="form-select" id="eventType" name="event_type" ng-model="selectedEvent.event_type" required
              disabled>
              <option value="" disabled selected>Select an event type</option>
              <option value="CELEBRATION">Celebration</option>
              <option value="BIRTHDAY">Birthday</option>
              <option value="SEMINAR">Seminar</option>
              <option value="ENVIRONMENTAL">Environmental</option>
              <option value="FUNERAL">Funeral / Burial</option>
            </select>
          </div>

          <div class="mb-3 col-12">
            <label for="" class="form-label">Title</label>
            <input type="text" class="form-control" id="" name="email" placeholder="" required
              ng-model="selectedEvent.event_name" disabled>
          </div>

          <div class="mb-3 col-12">
            <label for="eventDateTime" class="form-label">From</label>
            <input type="datetime-local" class="form-control" id="eventDateTime" name="eventDateTime" required
              ng-model="selectedEvent.start_date">
          </div>

          <div class="mb-3 col-12">
            <label for="eventDateTime" class="form-label">To</label>
            <input type="datetime-local" class="form-control" id="eventDateTime" name="eventDateTime" required
              ng-model="selectedEvent.end_date">
          </div>

          <div class="mb-3 col-12">
            <label for="" class="form-label">Details</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3" required
              ng-model="selectedEvent.event_description" disabled></textarea>
          </div>
          <div class="mb-3 col-12">
            <label for="" class="form-label">Location</label>
            <input type="text" class="form-control" id="" name="email" placeholder="" required
              ng-model="selectedEvent.location">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
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
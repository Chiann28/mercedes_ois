<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin MERCEDEX</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

  <!-- NASHIE CSS <3 -->
  <link rel="stylesheet" href="../framework/CSS/NashieCss.css">

</head>

<body class="mdx-body-color">

  <!-- Sidebar -->
  <?php require_once '../framework/Components/mdx_sidebar.php'; ?>
  <!-- Header -->
  <?php require_once '../framework/Components/mdx_header.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="mdx-content pt-5 mt-5" id="mdx_content">
    <div class="container-fluid">
      <!-- START CODING HERE -->
      <div class="row">
        <div class="col-12 col-lg-8">
          <div class="row">
            <div class="col-12 pb-3">
              <div class="bg-light p-3 rounded">
                <div class="row">
                  <div class="col-6 col-md-3">
                    <div
                      class="d-flex justify-content-between align-items-center p-3 mdx-bg-blue-300 text-light rounded">
                      <i class="fa-solid fa-house display-4" style="opacity: 40%"></i>
                      <div class="ms-2 text-end">
                        <span class="fw-semibold fs-3">457</span>
                        <p class="m-0">Total Units</p>

                      </div>

                    </div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div
                      class="d-flex justify-content-between align-items-center p-3 mdx-bg-green-300 text-light rounded">
                      <i class="fa-solid fa-house-circle-check display-4" style="opacity: 40%"></i>
                      <div class="ms-2 text-end">
                        <span class="fw-semibold fs-3">376</span>
                        <p class="m-0">Active Units</p>

                      </div>

                    </div>
                  </div>
                  <div class="col-6 col-md-3 mt-2 mt-lg-0">
                    <div
                      class="d-flex justify-content-between align-items-center p-3 mdx-bg-yellow-300 text-light rounded">
                      <i class="fa-solid fa-circle-exclamation display-4" style="opacity: 40%"></i>
                      <div class="ms-2 text-end">
                        <span class="fw-semibold fs-3">47</span>
                        <p class="m-0">Complaints</p>

                      </div>

                    </div>
                  </div>
                  <div class="col-6 col-md-3 mt-2 mt-lg-0">
                    <div
                      class="d-flex justify-content-between align-items-center p-3 mdx-bg-red-300 text-light rounded">
                      <i class="fa-solid fa-triangle-exclamation display-4" style="opacity: 40%"></i>
                      <div class="ms-2 text-end">
                        <span class="fw-semibold fs-3">19</span>
                        <p class="m-0">Unresolved</p>

                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 pb-3">
              <div class="bg-light p-3 rounded">
                <div class="d-flex align-items-center mdx-border-bottom pb-3">
                  <h3 class="m-0 mdx-text-scarlet"><i class="fa-solid fa-money-bill-trend-up me-2"></i></h3>
                  <h3 class="m-0">Monthly Collection Rate</h3>

                </div>

                <canvas id="myChart" width="400" height="222" class="my-4"></canvas>
              </div>
            </div>
          </div>
        </div>


        <div class="col-12 col-lg-4">
          <div class="row">
            <div class="col-12"> <!-- ANNOUNCEMENT -->
              <div class="bg-light rounded p-4">
                <div class="d-flex justify-content-between align-items-center mdx-border-bottom pb-3">
                  <h3 class="m-0"> <i class="fa-solid fa-calendar me-1 mdx-text-scarlet"></i>Announcements</h3>
                  <button class="mdx-square-btn bg-light px-3 py-2 rounded">See all</button>
                </div>

                <div class="my-1">
                  <div class="d-flex py-3 mdx-border-bottom-light">
                    <div class="ms-3">
                      <a href="#" class="text-decoration-none h6 mdx-text-hover">Announcement - <span class="fw-light">
                          Lorem ipsum dolor sit amet consectet..</span></a>
                    </div>

                  </div>
                </div>

                <div class="my-1">
                  <div class="d-flex py-3 mdx-border-bottom-light">
                    <div class="ms-3">
                      <a href="#" class="text-decoration-none h6 mdx-text-hover">Announcement - <span class="fw-light">
                          Lorem ipsum dolor sit amet consectet..</span></a>

                    </div>
                  </div>

                  <div class="my-1"> <!-- EVENTS -->
                    <div class="d-flex py-3 mdx-border-bottom-light">
                      <div class="ms-3">
                        <a href="#" class="text-decoration-none h6 mdx-text-hover">Announcement - <span
                            class="fw-light"> Lorem ipsum dolor sit amet consectet..</span></a>
                      </div>

                    </div>
                  </div>



                </div>
              </div>
            </div>

            <div class="col-12 mt-3">
              <div class="bg-light rounded p-4">
                <div class="d-flex justify-content-between align-items-center mdx-border-bottom pb-3">
                  <h3 class="m-0"> <i class="fa-solid fa-calendar me-1 mdx-text-scarlet"></i>Upcoming Events</h3>
                  <button class="mdx-square-btn bg-light px-3 py-2 rounded">See all</button>
                </div>

                <div class="my-3">
                  <div class="d-flex py-3 mdx-border-bottom-light">
                    <div class="ms-3">
                      <a href="#" class="text-decoration-none h6 mdx-text-hover">Event Title</a>
                      <p class="small mt-1">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo praesentium,
                        illum eum doloribus
                        maiores non laboriosam nihil vita..</p>
                    </div>

                  </div>
                </div>

                <div class="my-3">
                  <div class="d-flex py-3 mdx-border-bottom-light">
                    <div class="ms-3">
                      <a href="#" class="text-decoration-none h6 mdx-text-hover">Event Title</a>
                      <p class="small mt-1">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo praesentium,
                        illum eum doloribus
                        maiores non laboriosam nihil vita..</p>
                    </div>

                  </div>
                </div>

                <div class="my-3">
                  <div class="d-flex py-3 mdx-border-bottom-light">
                    <div class="ms-3">
                      <a href="#" class="text-decoration-none h6 mdx-text-hover">Event Title</a>
                      <p class="small mt-1">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo praesentium,
                        illum eum doloribus
                        maiores non laboriosam nihil vita..</p>
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

  <!-- bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

  <script src="../framework/JS/jsForStyling.js"></script>

  <!-- CHART JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: [
          'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ],

        datasets: [{
          label: 'Collection Rate',
          data: [50, 54, 78, 38, 49, 78, 39, 28, 59,0,0,0],
          borderWidth: 3,
          tension: 0.4,
          borderColor: '#f55355' ,
          backgroundColor: '#f5535679',
          fill: true,

        }]
      },
      options: {
        animations: {
          tension: {
            duration: 1000,
            easing: 'linear',
            from: 1,
            to: 0.5,
            loop: true
          }
        },
        plugins: {
          legend: {
            display: false
          },

        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            min: 1,     // lowest value
            max: 100,   // highest value
            ticks: {
              stepSize: 20
            },
          }
        }
      }

    });
  </script>


</body>

</html>
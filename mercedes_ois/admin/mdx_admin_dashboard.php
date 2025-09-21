<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
    <script src="../../mercedes_ois/admin/js/AdminController.js"></script>

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

<body class="mdx-body-color" ng-controller="AdminController" ng-init="loadDashboard();">

    <!-- Sidebar -->
    <?php require_once '../framework/Components/mdx_sidebar.php'; ?>
    <!-- Header -->
    <?php require_once '../framework/Components/mdx_header.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="mdx-content pt-5 mt-5" id="mdx_content">
        <div class="container-fluid">
            <!-- START CODING HERE -->
            <div class="row align-items-stretch">
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <!-- <div class="col-12 pb-3">
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
                                            <i class="fa-solid fa-house-circle-check display-4"
                                                style="opacity: 40%"></i>
                                            <div class="ms-2 text-end">
                                                <span class="fw-semibold fs-3">376</span>
                                                <p class="m-0">Active Units</p>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 mt-2 mt-lg-0">
                                        <div
                                            class="d-flex justify-content-between align-items-center p-3 mdx-bg-yellow-300 text-light rounded">
                                            <i class="fa-solid fa-circle-exclamation display-4"
                                                style="opacity: 40%"></i>
                                            <div class="ms-2 text-end">
                                                <span class="fw-semibold fs-3">47</span>
                                                <p class="m-0">Complaints</p>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 mt-2 mt-lg-0">
                                        <div
                                            class="d-flex justify-content-between align-items-center p-3 mdx-bg-red-300 text-light rounded">
                                            <i class="fa-solid fa-triangle-exclamation display-4"
                                                style="opacity: 40%"></i>
                                            <div class="ms-2 text-end">
                                                <span class="fw-semibold fs-3">19</span>
                                                <p class="m-0">Unresolved</p>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> -->

                        <div class="col-12 p-3 pt-0 bg-light rounded border border-dark-subtle">

                            <h3 class="my-4 text-muted">Overview
                            </h3>
                            <div class="mdx-body-color p-3 rounded border border-dark-subtle">
                                <div class="row" id="myTab" role="tablist">
                                    <div class="col-md-6 mt-3 mt-lg-0">
                                        <div class="p-3 bg-light rounded nav-link active" id="tab1-tab"
                                            data-bs-toggle="tab" data-bs-target="#tab1" role="tab"
                                            style="cursor: pointer; min-height: 15vh;">

                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <p class="m-0 fs-3">₱{{ TotalCollectionCount || '2,234,534.35' }}</p>
                                                <div class="" style="border-radius: 50%">
                                                    <i class="fa-regular fa-money-bill-1 display-5"
                                                        style="opacity: 75%;"></i>
                                                </div>
                                            </div>
                                            <p class="m-0 mt-3 fs-6 fw-light">Total Collection</p>
                                            <p class="small mb-0 mt-1 fw-light"><span
                                                    class="mdx-text-green fw-semibold">+435,043.21</span>
                                                from this month </p>

                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3 mt-lg-0">
                                        <div class="p-3 bg-light rounded nav-link" id="tab1-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab2" role="tab"
                                            style="cursor: pointer; min-height: 15vh;">

                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <p class="m-0 fs-3">{{ EventCount || '1,245' }}</p>
                                                <div class="" style="border-radius: 50%">
                                                    <i class="fa-solid fa-arrows-spin display-5"
                                                        style="opacity: 75%;"></i>
                                                </div>
                                            </div>
                                            <p class="m-0 mt-3 fs-6 fw-light">Total Turnover</p>
                                            <p class="small mb-0 mt-1 fw-light"><span class="mdx-text-yellow">23</span>
                                                from this month </p>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="bg-light tab-content pt-0" id="myTabContent">
                                <div class="tab-pane show active" id="tab1" role="tabpanel">
                                    <div class="col-12">
                                        <canvas id="myChart" width="400" height="222" class="my-4"></canvas>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2" role="tabpanel">
                                    <div class="col-12">
                                        <canvas id="myChart2" width="400" height="222" class="my-4"></canvas>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>


                <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-light rounded p-4 border border-dark-subtle">

                                        <div class="row my-3">
                                            <div class="col-8 d-flex justify-content-start align-items-center">
                                                <div>
                                                    <span class="h1 fw-semibold">1.3K</span>
                                                    <span class="h4 text-muted">/ 1.8K Units</span>
                                                    <p class="m-0 text-muted">Current Active Unit</p>
                                                </div>
                                            </div>
                                            <div class="col-4 d-flex justify-content-center align-items-center">
                                                <canvas id="roundChart" width="100" height="100"></canvas>
                                            </div>
                                        </div>





                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="bg-light p-4 border border-dark-subtle rounded">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-champagne-glasses mdx-text-yellow display-1"></i>
                                    </div>
                                    <div class="col-8 d-flex flex-column justify-content-center" style="overflow: hidden;">
                                        <p class="h3 m-0 text-nowrap">MDX Deployment</p>
                                        <p class="h5 mt-3 mb-0 text-muted">CELEBRATION</p>
                                        <p class="mb-0 mt-1 text-muted">Today, 2025-09-21</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="bg-light rounded p-4 border border-dark-subtle">
                                <div class="d-flex justify-content-between align-items-center mdx-border-bottom pb-3">
                                    <h3 class="m-0 text-muted">Upcoming
                                        Events</h3>
                                    <button class="mdx-square-btn bg-light px-3 py-2 rounded"
                                        onclick="window.location.href='mdx_events.php'">
                                        See all
                                    </button>

                                </div>



                                <div class="my-3">
                                    <div class="py-3 mdx-border-bottom-light" ng-repeat="event in DashboardEvents">


                                        <div class="row">
                                            <div
                                                class="col-3 p-2 rounded border d-flex align-items-center justify-content-center">
                                                <i class="fa-solid text-secondary fs-2" ng-class="{ 'fa-leaf mdx-text-green' : event.event_type === 'ENVIRONMENTAL',
                                                'fa-cake-candles mdx-text-pink' : event.event_type === 'BIRTHDAY',
                                                'fa-dove text-secondary' : event.event_type === 'FUNERAL',
                                                'fa-comments mdx-text-blue' : event.event_type === 'SEMINAR',
                                                'fa-champagne-glasses mdx-text-yellow' : event.event_type === 'CELEBRATION',
                                                }"></i>
                                            </div>
                                            <div class="col-9">
                                                <div class="row">
                                                    <div class="col-8"><a href="#"
                                                            class="text-decoration-none h6 mdx-text-hover"> {{
                                                            event.event_name }}</a></div>
                                                    <div class="col-4">
                                                        <p class="text-muted mb-0 small text-end col-12"> {{
                                                            event.date_start }}</p>
                                                    </div>
                                                </div>

                                                <p class="text-muted m-0">{{ event.event_type }}</p>
                                                <p class="small text-muted m-0"> {{ event.event_description }}</p>
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
    </div>

    <!-- bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>

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
                    label: '',
                    data: [20, 35, 30, 45, 40, 55, 50, 65, 60, 75, 70, 85],
                    borderWidth: 3,
                    tension: 0.4,
                    borderColor: '#f55355',
                    fill: false,

                }],


            },
            options: {
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
                        min: 1, // lowest value
                        max: 100, // highest value
                        ticks: {
                            stepSize: 20
                        },
                    }
                }
            }

        });

        const ctx2 = document.getElementById('myChart2');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],

                datasets: [{
                    label: '',
                    data: [20, 35, 30, 45, 40, 70, 50, 35, 25, 75, 70, 85],
                    borderWidth: 3,
                    tension: 0.4,
                    borderColor: '#6474ffff',
                    fill: false,

                }],


            },
            options: {
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
                        min: 1, // lowest value
                        max: 100, // highest value
                        ticks: {
                            stepSize: 20
                        },
                    }
                }
            }

        });

        const ctx3 = document.getElementById('roundChart');
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [75, 25], // 75% filled, 25% empty
                    backgroundColor: ['#28a745', '#e9ecef'], // green and light gray
                    borderWidth: 0,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: false,
                cutout: '80%', // thickness of ring
                plugins: {
                    legend: { display: false }, // hide legend
                    tooltip: { enabled: false }, // disable tooltip
                }
            },
            plugins: [{
                // Custom text in center
                id: 'textCenter',
                beforeDraw(chart) {
                    const { width } = chart;
                    const { height } = chart;
                    const ctx = chart.ctx;
                    ctx.restore();
                    const fontSize = (height / 100).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";
                    const text = "75%";
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2;
                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }]
        });
    </script>


</body>

</html>
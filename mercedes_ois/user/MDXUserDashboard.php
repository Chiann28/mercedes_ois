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

    <script src="../../mercedes_ois/user/js/UserDashboardController.js"></script>



    <!-- NASHIE CSS <3 -->
    <link rel="stylesheet" href="../framework/CSS/NashieCss-Frontend.css">
    <link rel="stylesheet" href="../framework/CSS/user_dashboard_anims.css">
</head>

<body class="bg-light" style="" ng-controller="UserDashboardController" ng-init="init();">
    <?php require_once '../framework/Components/mdx_user_header.php'; ?>

    <div class="container-md mb-3" style="min-height: 87vh">
        <!-- code here temporariliy
         will update the UI later
         add
         - transaction related back-ends
         - events fetching
         - announcement fetching
         - log out
         - requests and incident reports
         
        -->
        <!-- <div class="col-12 bg-dark mt-3 rounded" style="height: 50vh; background: url(https://picsum.photos/1440/720); background-size: cover;
        background-position: center;"></div> -->

        <div class="row mt-3">
            <div class="col-12 my-3" style="height: 25vh;">
                <div class="" style="height: 100%">
                    <div class="row" style="height: 100%">
                        <!-- <div class="col-4">
                            <div class="p-5 rounded" style="height: 100%; background: linear-gradient(to right, #f55355, #ff9696ff"></div>
                        </div> -->
                        <div class="col-12">
                            <div class="p-4 rounded shadow d-flex flex-column justify-content-center"
                                style="height: 100%; background: #f55355">
                                <div class="col-12 text-light">
                                    <div class="row">
                                        <div class="col-8">
                                            <p class="h1">{{ data.fullname || 'Loading...' }}</p>
                                            <p class="h5 fw-normal">{{ data.accountnumber || 'Loading...' }}</p>
                                        </div>
                                        <div class="col-4 d-flex justify-content-end align-items-center">
                                            <a href=""><i
                                                    class="fa-solid fa-circle-chevron-right display-4 text-light"></i></a>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-12 text-end text-light">
                                    <p class="h5 fw-normal">Arrears</p>
                                    <p class="h3">PHP 1,235.00</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-12 my-3" style="height: 25vh;">
                <div class="" style="height: 100%">
                    <div class="row" style="height: 100%">
                        <div class="col-lg-6">
                            <div class="bg-light shadow p-4 rounded" style="height: 100%; overflow:hidden;">
                                <div class="row" style="height: 100%;">
                                    <div class="col-10 d-flex flex-column justify-content-center">
                                        <p class="h5 fw-light mb-4">Upcomming Event</p>
                                        <p class="h3 fw-semi-bold">MERCEDES WEB DEPLOYMENT</p>
                                        <p class="small">2025-10-31</p>



                                    </div>
                                    <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                                        <i class="fa-solid fa-wine-glass" style="font-size: 5rem; color: #f6cb18"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="bg-light shadow p-4 rounded" style="height: 100%; overflow:hidden;">
                                <div class="row" style="height: 100%;">
                                    <div class="col-10 d-flex flex-column justify-content-center">
                                        <p class="h5 fw-light mb-4">Latest Announcement</p>
                                        <p class="h3 fw-semi-bold">System Maintenance</p>
                                        <p class="small">Scheduled downtime for system upgrade</p>
                                        <p class="small">2025-10-31</p>



                                    </div>
                                    <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                                        <i class="fa-solid fa-bullhorn" style="font-size: 5rem; color: #3599dd"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-lg-4">
                <a href="MDX_U_Incident.php" class="text-decoration-none text-dark">
                    <div class="p-5 shadow rounded mt-3 lower-card position-relative d-flex flex-column justify-content-between"
                        style="height: 25vh;">
                        <div class="lower-card-content">
                            <h5 class="fw-bold mb-1">Report Incident</h5>
                            <p class="lower-card-desc mb-0 small">
                                Quickly report any issues or emergencies for immediate response.
                            </p>
                        </div>

                        <div class="lower-card-item position-absolute">
                            <i class="fa-solid fa-triangle-exclamation lower-card-icon" style="font-size: 7rem;"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4">
                <div class="p-5 shadow rounded mt-3 lower-card position-relative d-flex flex-column justify-content-between"
                    style="height: 25vh;">
                    <div class="lower-card-content">
                        <h5 class="fw-bold mb-1">Requests</h5>
                        <p class="lower-card-desc mb-0 small">
                            File a request and we'll get back to you as soon as possible.
                        </p>
                    </div>

                    <div class="lower-card-item position-absolute">
                        <i class="fa-solid fa-bell-concierge lower-card-icon-bounce" style="font-size: 7rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <a href="MDXAccountSettings.php" class="text-decoration-none text-dark">
                    <div class="p-5 shadow rounded mt-3 lower-card position-relative d-flex flex-column justify-content-between"
                        style="height: 25vh; cursor: pointer;">
                        <div class="lower-card-content">
                            <h5 class="fw-bold mb-1">Account Settings</h5>
                            <p class="lower-card-desc mb-0 small">
                                Manage your account details.
                            </p>
                        </div>

                        <div class="lower-card-item position-absolute">
                            <i class="fa-solid fa-gear lower-card-icon-rotate" style="font-size: 7rem;"></i>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>



    <?php require_once '../framework/Components/mdx_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>

</body>

</html>
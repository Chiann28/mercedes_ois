<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MERCEDEX</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- NASHIE_CSS -->
    <link rel="stylesheet" href="../framework/css/NashieCss.css">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

    <!-- JAVASCRIPT -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
    <script src="../../mercedes_ois/user/js/LoginController.js"></script>

</head>

<body class="bg-dark" ng-controller="LoginController" ng-init="init()">
    <!-- Header -->
    <nav class="fixed-top navbar navbar-expand-lg bg-none">
        <div class="container">

            <!-- <a class="navbar-brand text-light" href="#">LOGO</a> -->
            <a class="navbar-brand d-flex align-items-center" href="#" class="text-light">
                <img src="..\admin\logo_mercedes.png" alt="" style="height: 45px;">
                <span class="fw-bold h3 mb-0" style="color: #fe3131;">MERCEDES</span>
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                        <a class="nav-link text-light mdx-text-hover" href="#">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mdx-text-hover" href="#">About Us</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link text-light mdx-text-hover" href="MDXSignup.php">Sign up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mdx-text-hover" data-bs-toggle="modal"
                            data-bs-target="#loginModal" style="cursor: pointer;">Login</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Categories</a></li>
              <li><a class="dropdown-item" href="#">About Us</a></li>
              <li><a class="dropdown-item" href="#">Help</a></li>
              <li><a class="dropdown-item" href="#">Login</a></li>
            </ul>
          </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- HERO -->
    <section class="login-hero">
        <div class="container d-flex justify-content-md-center align-items-center p-4 p-md-0" style="height: 100vh;">
            <div class="text-light">
                <div class="text-md-center">
                    <div class="col-12 col-md-8 mx-auto">
                        <h1 class="fw-light display-1 w-100 mdx-fst-tnr">The Best Way to Nurture Your Home.</h1>
                    </div>

                </div>
                <div class="text-md-center mt-5 mb-5">
                    <div class="col-12 col-md-6 mx-auto">
                        <h3 class="fw-light w-100 fst-italic m-0">"The magic thing about home is that it feels good to
                            leave,
                            and it feels even better to come back."</h3>
                    </div>
                </div>

                <div class="text-md-center mt-5">
                    <div class="col-6 col-md-3 mx-md-auto">
                        <button type="button"
                            class="mdx-bordered-button mdx-btn-hover btn rounded-pill w-100 btn-lg text-decoration-underline"
                            data-bs-toggle="modal" data-bs-target="#loginModal">Get
                            Started</button>
                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- LOGIN MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="LoginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body py-3">
                    <div class="d-flex align-items-center my-3">
                        <span class="flex-grow-1 text-center display-6 mdx-fst-tnr">Login</span>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>


                    <div class="mt-4 mb-3 px-4">
                        <form>
                            <div class="position-relative mb-3">
                                <input type="text" class="form-control mdx-login-input pe-5" id="exampleInputEmail1"
                                    placeholder="username" aria-describedby="emailHelp" ng-model="username">
                                <i
                                    class="fa-regular fa-user fs-5 position-absolute top-50 end-0 translate-middle-y me-1"></i>
                            </div>

                            <div class="position-relative mb-2">
                                <input type="password" class="form-control mdx-login-input" id="exampleInputPassword1"
                                    placeholder="password" ng-model="password">
                                <i
                                    class="fa-regular fa-eye fs-5 position-absolute top-50 end-0 translate-middle-y me-1"></i>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <!-- <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label small" for="exampleCheck1">Remember me</label>
                                </div> -->

                                <a href="MDXResetPassword.php" class="text-decoration-none small mdx-text-scarlet">Forgot Password?</a>
                            </div>

                            <div class="text-md-center mt-5">
                                <div class="col-6 col-md-6 mx-auto">
                                    <button type="submit"
                                        class="mdx-bordered-button btn rounded-pill w-100 text-decoration-underline"
                                        ng-click="DoLogin()">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>
    </div>




    <!-- bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("exampleInputPassword1");
            const toggleIcon = passwordInput.parentElement.querySelector(".fa-eye");

            toggleIcon.addEventListener("click", function () {
                const isPassword = passwordInput.type === "password";
                passwordInput.type = isPassword ? "text" : "password";

                // Toggle icon style (optional but useful)
                this.classList.toggle("fa-eye");
                this.classList.toggle("fa-eye-slash");
            });
        });

    </script>

</body>

</html>
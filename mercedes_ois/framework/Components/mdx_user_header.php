<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="MDXUserDashboard.php">
            <img src="../admin/logo_mercedes.png" alt="Logo" style="height: 45px;">
            <span class="fw-bold h3 mb-0 ms-2" style="color: #fe3131;">MERCEDES</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item">
          <a class="nav-link text-light" href="MDXUserDashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="MDX_U_Request.php">Request</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="MDX_U_Incident.php">Report Incident</a>
        </li> -->
                <li class="nav-item">
                    <button class="btn btn-outline-light ms-2" type="button" id="logout_button" ng-click="DoLogOut()">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const logoutBtn = document.getElementById("logout_button");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function() {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to log out?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, log out",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    // 🔹 Step 2: Call the API only if confirmed
                    fetch("../../mercedes_ois/admin/api/AdminAPI.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                request_type: "Logout"
                            }),
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.result) {
                                Swal.fire({
                                    title: "Logged Out",
                                    text: "You have been successfully logged out.",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then(() => {
                                    sessionStorage.clear();
                                    localStorage.clear();
                                    window.location.href =
                                        "../../mercedes_ois/user/MDXLogin.php";
                                });
                            } else {
                                Swal.fire("Error", "Logout failed. Please try again.",
                                    "error");
                            }
                        })
                        .catch(err => {
                            console.error("Logout failed", err);
                            Swal.fire("Error", "Something went wrong.", "error");
                        });
                }
            });
        });
    }
});
</script>
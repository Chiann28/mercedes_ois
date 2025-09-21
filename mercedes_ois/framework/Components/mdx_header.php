<nav class="navbar navbar-expand-lg navbar-dark bg-dark mdx-navbar fixed-top" id="mainNavbar">
    <div class="container-fluid d-flex justify-content-end justify-content-lg-between">
        <button class="sidebar-toggler d-none d-lg-block" type="button" id="sidebarCollapse">
            <i class="fas fa-bars"></i>
        </button>
        <div class="d-flex">
            <button class="sidebar-toggler m-0" type="button" id="">
                <i class="fa-solid fa-user"></i>
            </button>
            <button class="sidebar-toggler m-0" type="button" id="logout_button" ng-click="DoLogOut()">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </div>

        <!-- <a class=" navbar-brand" href="#">MERCEDEX</a> -->


    </div>
</nav>
<!-- PUTANGINA VANILLA NALANG API NALANG YAN> -->
  <!-- TAMAD KA BOSS -->
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="MDXUserDashboard.php">
            <img src="../admin/logo_mercedes.png" alt="Logo" style="height: 45px;">
            <span class="fw-bold h3 mb-0 ms-2" style="color: #fe3131;">MERCEDES</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center">

                <li class="nav-item dropdown me-2">
                    <button class="btn btn-outline-light position-relative" id="notifDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" ng-click="LoadNotifications()">
                        <i class="fa-solid fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            ng-if="notifications.length > 0">
                            {{notifications.length}}
                        </span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown"
                        style="width: 600px; max-height: 350px; overflow-y: auto;">
                        <li ng-if="notifications.length === 0" class="dropdown-item text-center text-muted">
                            No new notifications
                        </li>
                        <li ng-repeat="notif in notifications"
                            class="dropdown-item border-bottom small d-flex align-items-start">
                            <span class="me-2 fs-5" ng-switch="notif.type">
                                <i ng-switch-when="Reminder" class="fa-solid fa-clock text-warning"></i>
                                <i ng-switch-when="Request" class="fa-solid fa-envelope text-info"></i>
                                <i ng-switch-when="Update" class="fa-solid fa-rotate text-primary"></i>
                                <i ng-switch-when="Announcement" class="fa-solid fa-bullhorn text-success"></i>
                                <i ng-switch-default class="fa-solid fa-bell text-secondary"></i>
                            </span>

                            <div class="flex-grow-1">
                                <strong>{{notif.title}}</strong><br>
                                <span>{{notif.message}}</span><br>
                                <small class="text-muted">{{notif.created_at | date:'medium'}}</small>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary ms-2" ng-click="MarkAsRead(notif.id)"
                                title="Mark as Read">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </li>
                    </ul>
                </li>
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
                                =
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
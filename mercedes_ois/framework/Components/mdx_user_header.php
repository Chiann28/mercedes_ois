<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                            ng-if="(notifications | filter:{n_status:'unread'}).length > 0">
                            {{ (notifications | filter:{n_status:'unread'}).length }}
                        </span>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown"
                        style="width: 600px; max-height: 350px; overflow-y: auto;">
                        <li ng-if="notifications.length === 0" class="dropdown-item text-center text-muted">
                            No new notifications
                        </li>
                        <li ng-repeat="notif in notifications" class="dropdown-item border-bottom"
                            style="cursor: pointer;">
                            <a class="text-decoration-none text-dark" ng-click="notif_click(notif.type)">
                                <div class="col-12 d-flex align-items-center">

                                    <span class="me-2 fs-5" ng-switch="notif.type">
                                        <i ng-switch-when="Reminder" class="fa-solid fa-clock text-warning fs-2"></i>
                                        <i ng-switch-when="Request" class="fa-solid fa-envelope text-info fs-2"></i>
                                        <i ng-switch-when="Update" class="fa-solid fa-rotate text-primary fs-2"></i>
                                        <i ng-switch-when="Announcement"
                                            class="fa-solid fa-bullhorn text-success fs-2"></i>
                                        <i ng-switch-default class="fa-solid fa-bell text-secondary fs-2"></i>
                                    </span>
                                    <div class="w-100 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-0" ng-class="{'fw-bold' : notif.n_status === 'unread'}">{{
                                                    notif.title }} </p>
                                                <p class="mb-0 small"
                                                    ng-class="{'fw-semibold' : notif.n_status === 'unread'}">{{
                                                    notif.message }}</p>
                                            </div>
                                            <a type="btn" class="ms-2 text-secondary"
                                                ng-show="notif.n_status === 'unread'" ng-click="MarkAsRead(notif.id)"
                                                title="Mark as Read">
                                                <i class="fa-solid fa-check-double"></i>
                                            </a>
                                        </div>
                                        <p class="text-muted small mb-0">{{notif.formatted_datetime | date:'medium'}}
                                        </p>
                                    </div>
                                </div>
                            </a>





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
</nav> -->


<style>
    .dropdown-menu {
  width: 350px;
  max-height: 350px;
  overflow-y: auto;
  overflow-x: hidden;
}

.dropdown-item .d-flex {
  flex-wrap: nowrap;
}

.dropdown-item p {
  word-break: break-word;
  white-space: normal;
}

#notifDropdown + .dropdown-menu {
  right: 0 !important;
  left: auto !important;
  transform: none !important;
}


#notifDropdown + .dropdown-menu {
  width: 350px;
  max-height: 350px;
  overflow-y: auto;
  overflow-x: hidden;
}


@media (max-width: 576px) {
  #notifDropdown + .dropdown-menu {
    width: 60vw !important;
    /* left: 5vw !important; */
    right: 5vw !important;
  }
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container d-flex justify-content-between align-items-center">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="MDXUserDashboard.php">
      <img src="../admin/logo_mercedes.png" alt="Logo" style="height: 45px;">
      <span class="fw-bold h3 mb-0 ms-2" style="color: #fe3131;">MERCEDES</span>
    </a>

    <!-- Right side -->
    <div class="d-flex align-items-center">

      <div class="dropdown me-2">
        <button class="btn btn-outline-light position-relative" id="notifDropdown" data-bs-toggle="dropdown"
          aria-expanded="false" ng-click="LoadNotifications()">
          <i class="fa-solid fa-bell"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            ng-if="(notifications | filter:{n_status:'unread'}).length > 0">
            {{ (notifications | filter:{n_status:'unread'}).length }}
          </span>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown"
          style=" max-width: 600px; max-height: 350px; overflow-y: auto;">
          <li ng-if="notifications.length === 0" class="dropdown-item text-center text-muted">
            No new notifications
          </li>

          <li ng-repeat="notif in notifications" class="dropdown-item border-bottom" style="cursor: pointer;">
            <a class="text-decoration-none text-dark" ng-click="notif_click(notif.type)">
              <div class="col-12 d-flex align-items-center">
                <span class="me-2 fs-5" ng-switch="notif.type">
                  <i ng-switch-when="Reminder" class="fa-solid fa-clock text-warning fs-2"></i>
                  <i ng-switch-when="Request" class="fa-solid fa-envelope text-info fs-2"></i>
                  <i ng-switch-when="Update" class="fa-solid fa-rotate text-primary fs-2"></i>
                  <i ng-switch-when="Announcement" class="fa-solid fa-bullhorn text-success fs-2"></i>
                  <i ng-switch-default class="fa-solid fa-bell text-secondary fs-2"></i>
                </span>

                <div class="w-100 ms-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="mb-0" ng-class="{'fw-bold': notif.n_status === 'unread'}">
                        {{ notif.title }}
                      </p>
                      <p class="mb-0 small" ng-class="{'fw-semibold': notif.n_status === 'unread'}">
                        {{ notif.message }}
                      </p>
                    </div>
                    <a type="btn" class="ms-2 text-secondary" ng-show="notif.n_status === 'unread'"
                      ng-click="MarkAsRead(notif.id)" title="Mark as Read">
                      <i class="fa-solid fa-check-double"></i>
                    </a>
                  </div>
                  <p class="text-muted small mb-0">{{ notif.formatted_datetime | date:'medium' }}</p>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>


      <button class="btn btn-outline-light ms-2" type="button" id="logout_button" ng-click="DoLogOut()">
        <i class="fa-solid fa-right-from-bracket"></i>
      </button>
    </div>
  </div>
</nav>






<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const logoutBtn = document.getElementById("logout_button");
        if (logoutBtn) {
            logoutBtn.addEventListener("click", function () {
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
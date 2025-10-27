var app = angular.module("mercedesApp", []);

app.service("API", function ($http) {
  this.getApi = function (url, params) {
    return $http({
      method: "GET",
      url: url,
      params: params,
    });
  };

  this.postApi = function (url, data) {
    return $http({
      method: "POST",
      url: url,
      data: data,
    });
  };
});

// Controller Start
app.controller("UserDashboardController", function ($scope, API) {
  $scope.client = "mercedes";

  $scope.init = function () {
    var data = {
      client: $scope.client,
      request_type: "GetUserData",
    };

    API.getApi("api/UserDashboardAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.data = final_response;
      console.log($scope.data);
      $scope.GetArrears();
      $scope.GetNotifications();
      if ($scope.data.is_otp === "1") {
        var modalEl = document.getElementById("forceModal");
        var modal = new bootstrap.Modal(modalEl, {
          backdrop: "static",
          keyboard: false,
        });
        modal.show();
      }
    });
  };

  $scope.GetArrears = function () {
    var data = {
      client: $scope.client,
      accountnumber: $scope.data.accountnumber,
      request_type: "GetArrears",
    };
    // console.log(data);
    API.getApi("api/UserDashboardAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.arrears = final_response[0];
      console.log($scope.arrears);
    });
  };

  $scope.GetNotifications = function () {
    var data = {
      accountnumber: $scope.data.accountnumber,
      request_type: "GetNotifications",
    };

    API.getApi("api/UserDashboardAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.notifications = final_response;
      console.log($scope.notifications);
    });
  };

  $scope.MarkAsRead = function (id) {
    var data = {
      accountnumber: $scope.data.accountnumber,
      notif_id: id,
      request_type: "MarkAsRead",
    };

    API.getApi("api/UserDashboardAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.notifications = final_response;
      console.log($scope.notifications);
      $scope.GetNotifications();
    });
  };

  $scope.notif_click = function (type) {
    switch (type) {
      case "Incident Update":
        window.location.href = "MDX_U_Incident.php";
        break;
      case "Request Update":
        window.location.href = "MDX_U_Request.php";
        break;
      default:
        console.log("Unknown notification type:", type);
        break;
    }
  };

  $scope.DoUpdatePassword = function () {
    var data = {
      client: $scope.client,
      accountnumber: $scope.data.accountnumber,
      password: $scope.updatePassword,
      request_type: "DoUpdatePassword",
    };

    API.postApi("api/UserDashboardAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      console.log(final_response);

      if (final_response.success) {
        // Hide modal only after successful update
        var modalEl = document.getElementById("forceModal");
        var modal = bootstrap.Modal.getInstance(modalEl); // get existing instance
        if (modal) modal.hide();

        Swal.fire({
          icon: "success",
          title: "Password Updated",
          text: "Your password has been updated successfully.",
          timer: 2000,
          showConfirmButton: false,
          willClose: () => {
          // 🔥 Automatically log out after alert closes
          var logoutData = {
            request_type: "Logout",
          };
          API.getApi("api/UserDashboardAPI.php", logoutData).then(function () {
            // Redirect to login page
            window.location.href = "MDXLogin.php";
          });
        },
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Update Failed",
          text: final_response.message || "Please try again.",
        });
      }
    });
  };
});

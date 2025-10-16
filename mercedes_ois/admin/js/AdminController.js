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
app.controller("AdminController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.VerifySession = function () {
    console.log("Welcome Admin");
    API.getApi("api/AdminAPI.php", { request_type: "VerifySession" }).then(
      function (response) {
        var final_response = response.data;

        if (final_response.result && final_response.role === "admin") {
          console.log("Welcome " + final_response.username + " (Admin)");
        } else if (final_response.result) {
          window.location.href = "../../mercedes_ois/user/MDXUserDashboard.php";
        } else {
          window.location.href = "../../mercedes_ois/user/MDXLogin.php";
        }
      }
    );
  };

  $scope.loadDashboard = function () {
    // $scope.DoAutoPostAnnouncement();
    $scope.DoGetEventDashboard();
    // $scope.DoAutoEmaileDue();
  };

  $scope.DoAutoPostAnnouncement = function () {
    var data = {
      client: $scope.client,
      request_type: "DoAutoPostAnnouncement",
    };

    API.getApi("api/AdminAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        console.log("Announcement Posted");
      }
    });
  };

  $scope.DoAutoEmaileDue = function () {
    var today = new Date().toISOString().split("T")[0];
    var lastRun = localStorage.getItem("DoAutoEmaileDueLastRun");

    if (lastRun === today) {
      console.log("Auto Email already executed today. Skipping...");
      return;
    }

    Swal.fire({
      title: "Loading...",
      text: "Please Wait...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      request_type: "DoAutoEmaileDue",
    };

    API.getApi("api/AdminAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        swal.close();
        localStorage.setItem("DoAutoEmaileDueLastRun", today);
        console.log("Auto Email executed successfully for " + today);
      }
    });
  };

  $scope.init = function () {
    console.log("Welcome User");
  };

  $scope.DoGetEventDashboard = function () {
    var data = {
      client: $scope.client,
      request_type: "DoGetEventDashboard",
    };
    API.getApi("api/AdminAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        $scope.DashboardEvents = final_response;
        console.log($scope.DashboardEvents);
      }
    });
  };
});

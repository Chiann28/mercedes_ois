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
app.controller("AdminReportsController", function ($scope, API) {
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

  $scope.GetReport = function (type) {
    switch (type) {
      case "resident_masterlist":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          request_type: "resident_masterlist",
        };
        break;
      case "announcement_history":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          request_type: "announcement_history",
        };
      case "payment_collection":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          request_type: "payment_collection",
        };
      case "events":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          request_type: "events",
        };
        break;
      default:
        break;
    }

    Swal.fire({
      title: "Loading...",
      text: "Please Wait...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    API.getApi("api/AdminReportsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        $scope.data = final_response;
        console.log("DATA", final_response);
        swal.close();
      }
    });
  };
});

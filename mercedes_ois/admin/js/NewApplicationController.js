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
app.controller("NewApplicationController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.newapp = $scope.newapp || {};

  $scope.VerifySession = function () {
    console.log("New App Loaded");
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

  $scope.GetAccountDetails = function (accountnumber) {
    console.log(accountnumber);
    Swal.fire({
      title: "Loading...",
      text: "Fetching account list, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: "GetAccountDetails",
    };

    API.getApi("api/LedgerAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.customer = final_response;

      if (final_response) {
        $scope.GetTransactionHistory($scope.customer.accountnumber);
      }
      Swal.close();
    });
  };

  $scope.DoCreateAccount = function () {
    console.log($scope.first_name, $scope.last_name, $scope.role, $scope.username, $scope.password);
    Swal.fire({
      title: "Loading...",
      text: "Proccessing New Application. Please Wait...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      username: $scope.username,
      password: $scope.password,
      role: $scope.role,
      first_name: $scope.first_name,
      last_name: $scope.last_name,
      request_type: "DoCreateAccount",
    };

    API.getApi("api/NewApplicationAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      console.log (final_response);

      if (final_response) {
        //$scope.GetTransactionHistory($scope.customer.accountnumber);
        console.log('Success Account Creation')
      }
      Swal.close();
    });
  };

 
});

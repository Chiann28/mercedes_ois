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
app.controller("AccountSettingsController", function ($scope, API) {
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
      $scope.GetNotifications();
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

  $scope.get_transaction_history = function () {
    var data = {
      client: $scope.client,
      request_type: "get_transaction_history",
    };

    API.getApi("api/UserDashboardAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.transaction_data = final_response;
      console.log("transaction data: ", $scope.transaction_data);
    });
  };

  $scope.GetTransactionDetails = function (details) {
    $scope.td = details;
  };

  $scope.InitializeUpdating = function () {
    $scope.isEditing = !$scope.isEditing;
  };

  $scope.UpdateAccount = function () {
    console.log($scope.data);
    var data = {
      client: $scope.client,
      params: $scope.data,
      request_type: "UpdateAccount",
    };
    API.postApi("api/AccountSettingsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.data = final_response;
      console.log($scope.data);
      $scope.response = final_response;
      if ($scope.response.result) {
        Swal.fire({
          title: "Success!",
          text: $scope.response.message,
          icon: "success",
          confirmButtonText: "Done",
        }).then((res) => {
          if (res.isConfirmed) {
            location.reload();
          }
        });
      } else {
        Swal.fire({
          title: "Error",
          text: $scope.response.message,
          icon: "error",
          confirmButtonText: "OK",
        });
        $scope.isEditing = false;
      }
    });
  };
});

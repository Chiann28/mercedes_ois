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
});

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
app.controller("LoginController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.DoLogin = function () {
    var data = {
      client: $scope.client,
      username: $scope.username,
      password: $scope.password,
      request_type: "DoLogin",
    };

    API.postApi("api/LoginAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.data = final_response;
      $scope.role = final_response.role;

      if ($scope.data.result && $scope.role == "admin") {
        window.location.href = "../../mercedes_ois/admin/ADMIN_UI_TEMPLATE.php";
      } else if ($scope.data.result) {
        window.location.href = "../../mercedes_ois/user/MDXUserDashboard.php";
      } else {
        alert(final_response.message);
      }
    });
  };

  $scope.init = function () {
    console.log("Welcome User");
  };
});

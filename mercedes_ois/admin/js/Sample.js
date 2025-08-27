var app = angular.module("mercedesApp", []);

// Service to handle API requests
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
app.controller("SampleController", function ($scope, API) {
  $scope.searchClient = function () {
    var data = {
      client: $scope.client,
      request_type: "getData",
    };

    API.getApi("api/Sample.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.test = final_response;
      console.log($scope.test);
    });
  };

  $scope.init = function () {
    console.log("AngularJS is linked and controller initialized!");
  };
});

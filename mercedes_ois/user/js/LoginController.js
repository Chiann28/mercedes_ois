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
        window.location.href =
          "../../mercedes_ois/admin/mdx_admin_dashboard.php";
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

  $scope.DoAccountRequest = function (form) {
    // Prevent submission if form is invalid
    if (!form.$valid) {
      Swal.fire({
        title: "Incomplete Form",
        text: "Please fill out all required fields before submitting.",
        icon: "warning",
        confirmButtonText: "OK",
      });
      return; // stop execution
    }

    console.log($scope.accreq);

    var data = {
      client: $scope.client,
      params: $scope.accreq,
      request_type: "DoAccountRequest",
    };

    API.postApi("api/LoginAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.response = final_response;

      if ($scope.response.result) {
        Swal.fire({
          title: "Success!",
          text: $scope.response.message,
          icon: "success",
          confirmButtonText: "Done",
        }).then((res) => {
          if (res.isConfirmed) {
            // location.reload();
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

  $scope.PWResetCheckIfValid = function () {
    
    if (!$scope.pwr.input || $scope.pwr.input === "") {
      $scope.pwr.message = "Email or username can't be empty!";
      $scope.pwr.showMessage = true;
      return;
    }
    var data = {
      client: $scope.client,
      input: $scope.pwr.input,
      request_type: "PWResetCheckIfValid",
    };
    API.getApi("api/LoginAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.pwrresponse = final_response;
      $scope.pwr.email = final_response.data.email;
      if (!final_response.response) {
        $scope.pwr.message = final_response.message;
        $scope.pwr.showMessage = true;
      }else{
        
        document.getElementById('pwr_step1').style.display = "none";
        console.log(final_response);
        
        document.getElementById('pwr_step2').style.display = "block";
      }
    });
  };
});
